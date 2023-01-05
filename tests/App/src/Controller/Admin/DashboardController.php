<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Tests\App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use LongitudeOne\PropertyBundle\Controller\PropertyControllerTrait;
use LongitudeOne\PropertyBundle\Service\PropertyContextService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin')]
class DashboardController extends AbstractDashboardController
{
    use PropertyControllerTrait;

    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('PropertyBundle Dashbord Tests');
    }

    public function configureMenuItems(): iterable
    {
        $entities = $this->translator->trans('lopb.menu.extendable-entities', [], 'LongitudeOnePropertyBundle');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute($entities, 'fa-solid fa-wand-magic-sparkles', 'longitudeone_property_tests_app_admin_dashboard_list');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }

    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    #[Route('/properties/classes', name: 'longitudeone_property_tests_app_admin_dashboard_list')]
    public function listExtendableEntities(PropertyContextService $service): Response
    {
        return $this->renderExtendableEntities($service);
    }
}