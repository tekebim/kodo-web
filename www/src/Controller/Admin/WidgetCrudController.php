<?php

namespace App\Controller\Admin;

use App\Entity\Widget;
use App\Repository\WidgetRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;

class WidgetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Widget::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */

    /**
     * @param WidgetRepository $widgetRepository
     * @return Response
     */
    public function showMyWidget(WidgetRepository $widgetRepository): Response
    {

        $widgetsFiltered = $widgetRepository->findByEstablishment(519);

        return $this->render('Admin/widget.html.twig', [
            'widgets' => $widgetsFiltered,
        ]);
    }
}
