<?php

namespace App\Controller\Admin;

use App\Entity\Widget;
use App\Repository\EstablishmentRepository;
use App\Repository\WidgetRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class WidgetCrudController extends AbstractCrudController
{

    private $crudUrlGenerator;

    private $security;

    public function __construct(CrudUrlGenerator $crudUrlGenerator, Security $security)
    {
        $this->crudUrlGenerator = $crudUrlGenerator;
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Widget::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $entity = new Widget();
        $userEstablishment = $this->security->getUser()->getEstablishment();
        $establishment = $userEstablishment;
        $entity->addEstablishment($establishment);
        $entity->setToken($entity->generateToken());
        return $entity;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield DateTimeField::new('updatedAt', 'Dernière mise à jour')->setSortable(true)->hideOnForm()->hideOnDetail();
        yield TextField::new('token')->setFormTypeOption('disabled', 'disabled');
        yield TextField::new('domainAllowed');
        yield AssociationField::new('establishment')->hideOnForm()->hideOnIndex();
    }

    /**
     * @param Actions $actions
     * @return Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::DELETE);
    }

    /**
     * @param WidgetRepository $widgetRepository
     * @return Response
     */
    public function showMyWidget(WidgetRepository $widgetRepository, EstablishmentRepository $establishmentRepository): Response
    {
        $user = $this->getUser();
        $userEstablishmentID = $user->getEstablishmentID();

        $isPremium = $establishmentRepository->find($userEstablishmentID)->getIsPremium();

        $widgetsFiltered = $widgetRepository->findByEstablishment($userEstablishmentID);

        $urlNewWidget = $this->crudUrlGenerator
            ->build()
            ->setController(WidgetCrudController::class)
            ->setAction(Action::NEW)
            ->generateUrl();

        return $this->render('Admin/widget.html.twig', [
            'establishment_id' => $userEstablishmentID,
            'widgets' => $widgetsFiltered,
            'url_new_widget' => $urlNewWidget,
            'is_premium' => $isPremium
        ]);
    }
}
