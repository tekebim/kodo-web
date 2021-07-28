<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Entity\Category;
use App\Entity\Conference;
use App\Entity\Establishment;
use App\Entity\Podcast;
use App\Entity\User;
use App\Entity\Widget;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
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
    }

    /**
     * @Route("/admin/conference", name="admin_conference")
     */
    public function conference(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        $url = $routeBuilder->setController(ConferenceCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    /**
     * @Route("/admin/widgets", name="admin_widgets")
     */
    public function widgets(): Response
    {
        return $this->render('Admin/dashboard.html.twig', [
            'accounts' => 'Mes widgets',
        ]);
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

    /**
     * @return Dashboard
     */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('KodoTalks')
            ->setFaviconPath('favicon.svg')
            ->setTranslationDomain('fr');
    }

    /**
     * @return iterable
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Administration');
            yield MenuItem::linkToCrud('Articles', 'fas fa-book', Articles::class);
            yield MenuItem::linkToCrud('Podcasts', 'fas fa-microphone-alt', Podcast::class);
            yield MenuItem::linkToCrud('Catégories', 'fas fa-tags', Category::class);
            yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
            yield MenuItem::linkToCrud('Établissements', 'fas fa-city', Establishment::class);
            yield MenuItem::linkToCrud('Conférences', 'fas fa-copyright', Conference::class);
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
