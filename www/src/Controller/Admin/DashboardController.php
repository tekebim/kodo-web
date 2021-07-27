<?php

namespace App\Controller\Admin;

use App\Controller\HomeController;
use App\Entity\Category;
use App\Entity\Conference;
use App\Entity\Establishment;
use App\Entity\User;
use App\Entity\Widget;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $accounts = $this->getDoctrine()->getRepository(User::class)->count([]);

        return $this->render('Admin/dashboard.html.twig', [
            'accounts' => $accounts,
        ]);

        // return parent::index();

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        // return $this->render('some/path/my-dashboard.html.twig');

        // $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        // $url = $routeBuilder->setController(ConferenceCrudController::class)->generateUrl();

        // return $this->redirect($url);
    }

    /**
     * @Route("/admin/conference", name="admin_conference")
     */
    public function conference(): Response
    {
        // return parent::index();

        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        $url = $routeBuilder->setController(ConferenceCrudController::class)->generateUrl();

        return $this->redirect($url);

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    /**
     * @Route("/admin/widgets", name="admin_widgets")
     */
    public function widgets(): Response
    {
        // $accounts = $this->getDoctrine()->getRepository(User::class)->count([]);

        return $this->render('Admin/dashboard.html.twig', [
            'accounts' => 'Mes widgets',
        ]);

        // return parent::index();

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        // return $this->render('some/path/my-dashboard.html.twig');

        // $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        // $url = $routeBuilder->setController(ConferenceCrudController::class)->generateUrl();

        // return $this->redirect($url);
    }

    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function categories(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        $url = $routeBuilder->setController(CategoryCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('KodoTalks')
            ->setFaviconPath('favicon.svg')
            ->setTranslationDomain('fr');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Administration');
            yield MenuItem::linkToCrud('Catégories', 'fas fa-map-marker-alt', Category::class);
            yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-map-marker-alt', User::class);
            yield MenuItem::linkToCrud('Établissements', 'fas fa-map-marker-alt', Establishment::class);
            yield MenuItem::linkToCrud('Conférences', 'fas fa-map-marker-alt', Conference::class);
        }

        if ($this->isGranted('ROLE_CONTRIBUTOR')) {
            yield MenuItem::section('Configuration');
            yield MenuItem::linkToCrud('Mes Conférences', 'fas fa-map-marker-alt', Conference::class);
            yield MenuItem::linkToCrud('Mes widgets', 'fas fa-map-marker-alt', Widget::class)
                ->setAction('showMyWidget');
        }

        yield MenuItem::section('Account');
        yield MenuItem::linkToLogout('Déconnexion', 'fa fa-exit');
        yield MenuItem::linkToRoute('Quitter', 'fa fa-home', 'home');

    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('bundles/easyadmin/app.css');
    }
}
