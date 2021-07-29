<?php

namespace App\Controller\Admin;

use App\Entity\Conference;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ConferenceCrudController extends AbstractCrudController
{

    private $security;

    /**
     * ConferenceCrudController constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param Actions $actions
     * @return Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
    }

    /**
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return Conference::class;
    }

    /**
     * @param string $pageName
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel('Details');
        // TextField::new('imageFile')->setFormType(VichImageType::class),
        yield ImageField::new('imageName')->setBasePath('/uploads/conferences/images/')->onlyOnIndex();
        yield TextareaField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex();
        if ($this->isGranted('ROLE_ADMIN')) {
            yield BooleanField::new('isShared')->setLabel('Visible');
        }
        if ($this->isGranted('ROLE_CONTRIBUTOR')) {
            yield BooleanField::new('isBroadcasted')->setLabel('Diffusion');
        }
        yield TextField::new('name')->setLabel('Nom de la conférence');
        yield SlugField::new('slug')->setTargetFieldName('name')->hideOnIndex();
        yield DateTimeField::new('date', 'Date de la conférence');
        yield TextField::new('location')->setLabel('Emplacement');
        yield TextField::new('author')->setLabel('Auteur')->hideOnIndex();
        yield TextField::new('speakers')->setLabel('Intervenant(s)');
        if (Crud::PAGE_DETAIL === $pageName || Crud::PAGE_INDEX === $pageName) {
            yield ArrayField::new('category')->setLabel('Catégorie');
        } else {
            yield AssociationField::new('category', 'Catégorie');
        }
        yield AssociationField::new('establishment', 'Etablissement')->setPermission('ROLE_ADMIN');
        yield IntegerField::new('likes');
        yield FormField::addPanel('Description');
        yield TextEditorField::new('extract')->hideOnIndex();
        yield TextEditorField::new('description')->hideOnIndex();
    }

    /**
     * @param string $entityFqcn
     * @return Conference
     */
    public function createEntity(string $entityFqcn)
    {
        $entity = new Conference();
        if ($this->isGranted('ROLE_CONTRIBUTOR')) {
            $userEstablishment = $this->security->getUser()->getEstablishment();
            $estblishment = $userEstablishment->getName();
            $entity->setAuthor($estblishment);
        }
        $entity->setLikes(0);
        return $entity;
    }

    /**
     * @param SearchDto $searchDto
     * @param EntityDto $entityDto
     * @param FieldCollection $fields
     * @param FilterCollection $filters
     * @return QueryBuilder
     */
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);

        if ($this->isGranted('ROLE_ADMIN')) {
            // $response->getQuery()->execute();

            $response->where('entity.isBroadcasted = :broadcast')
                ->setParameter('broadcast', true)
                ->getQuery()
                ->execute();
        } else {
            $user = $this->security->getUser();
            $establishmentID = $user->getEstablishmentID();

            $response->where('entity.establishment = :establishment')
                ->setParameter('establishment', $establishmentID)
                ->getQuery()
                ->execute();
        }


        return $response;
    }

    /**
     * @param ConferenceRepository $conferenceRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function showEstablishmentConferences(ConferenceRepository $conferenceRepository, PaginatorInterface $paginator, Request $request): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $conferences = $conferenceRepository->findAll();
        } else {
            $user = $this->getUser();
            $userEstablishmentID = $user->getEstablishmentID();

            $conferencesSelected = $conferenceRepository->findBy(['establishment' => $userEstablishmentID]);

            $conferences = $paginator->paginate(
                $conferencesSelected,
                $request->query->getInt('page', 1),
                8
            );
        }
        return $this->render('Admin/conferences/list.html.twig', [
            'conferences' => $conferences,
        ]);
    }
}
