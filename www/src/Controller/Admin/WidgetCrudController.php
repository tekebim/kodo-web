<?php

namespace App\Controller\Admin;

use App\Entity\Widget;
use App\Repository\EstablishmentRepository;
use App\Repository\WidgetRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class WidgetCrudController extends AbstractCrudController
{

    private $crudUrlGenerator;

    public function __construct(CrudUrlGenerator $crudUrlGenerator)
    {
        $this->crudUrlGenerator = $crudUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Widget::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $entity = new Widget();
        $entity->setToken($entity->generateToken());
        return $entity;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield DateTimeField::new('updatedAt', 'Dernière mise à jour')->setSortable(true)->hideOnForm()->hideOnDetail();
        yield TextField::new('token')->setFormTypeOption('disabled', 'disabled');
        yield TextField::new('domainAllowed');
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
