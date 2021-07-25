<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // return parent::index();
        return 'ok';

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //${APP_DIR_NAME}
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('KodoTalks')
            ->setFaviconPath('favicon.svg');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Configuration');
        yield MenuItem::linktoDashboard('Item for Administrator', 'fa fa-tools')->setPermission('ROLE_ADMIN');

        /*
        if ($this->isGranted('ROLE_EDITOR')) {
            yield MenuItem::linkToCrud('Blog Posts', null, BlogPost::class);
        }
        */
        // yield MenuItem::linkToCrud('Blog Posts', null, BlogPost::class)->setPermission('ROLE_USER');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
