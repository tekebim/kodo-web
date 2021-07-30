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
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('Admin/dashboard.html.twig', [
                'accounts' => $accounts,
            ]);
        } else {
            //return $this->redirectToRoute('admin_conferences');
            // return $this->conferences();
            return $this->render('Admin/dashboard.html.twig', [
                'accounts' => $accounts,
            ]);
        }
    }

    /**
     * @Route("/admin/conferences", name="admin_conferences")
     */
    public function conferences(): Response
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
        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
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

    /*
    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            // adds the CSS and JS assets associated to the given Webpack Encore entry
            // it's equivalent to adding these inside the <head> element:
            // {{ encore_entry_link_tags('...') }} and {{ encore_entry_script_tags('...') }}
            ->addWebpackEncoreEntry('admin-app')

            // it's equivalent to adding this inside the <head> element:
            // <link rel="stylesheet" href="{{ asset('...') }}">
            ->addCssFile('build/admin.css')
            ->addCssFile('https://example.org/css/admin2.css')

            // it's equivalent to adding this inside the <head> element:
            // <script src="{{ asset('...'') }}"></script>
            ->addJsFile('build/admin.js')
            ->addJsFile('https://example.org/js/admin2.js')

            // use these generic methods to add any code before </head> or </body>
            // the contents are included "as is" in the rendered page (without escaping them)
            ->addHtmlContentToHead('<link rel="dns-prefetch" href="https://assets.example.com">')
            ->addHtmlContentToBody('<script> ... </script>')
            ->addHtmlContentToBody('<!-- generated at '.time().' -->')
            ;
    }
    */
}
