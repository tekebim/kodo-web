<?php

namespace App\Controller\Admin;

use App\Entity\Conference;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
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

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Conference::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Details'),
            // TextField::new('imageFile')->setFormType(VichImageType::class),
            ImageField::new('imageName')->setBasePath('/uploads/conferences/images/')->onlyOnIndex(),
            TextareaField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            BooleanField::new('isShared')->setLabel('Visible'),
            TextField::new('name')->setLabel('Nom de la conférence'),
            SlugField::new('slug')->setTargetFieldName('name')->hideOnIndex(),
            DateTimeField::new('date', 'Date de la conférence'),
            TextField::new('location')->setLabel('Emplacement'),
            TextField::new('author')->setLabel('Auteur')->hideOnIndex(),
            TextField::new('speakers')->setLabel('Intervenant(s)'),
            AssociationField::new('category', 'Catégorie'),
            AssociationField::new('establishment', 'Etablissement')->setPermission('ROLE_ADMIN'),
            IntegerField::new('likes')->setValue(0),
            FormField::addPanel('Description'),
            TextEditorField::new('extract')->hideOnIndex(),
            TextEditorField::new('description')->hideOnIndex(),
        ];
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
            $response->getQuery()->execute();
        } else {
            $user = $this->security->getUser();
            $establishmentID = $user->getEstablishmentID();

            $response->andWhere('entity.establishment = :establishment')
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
