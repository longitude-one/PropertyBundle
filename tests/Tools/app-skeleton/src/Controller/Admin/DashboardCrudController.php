<?php

namespace App\Controller\Admin;

use App\Entity\Reward;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use LongitudeOne\PropertyBundle\Controller\PropertyControllerTrait;
use LongitudeOne\PropertyBundle\Entity\Definition;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;

class DashboardCrudController extends AbstractDashboardController
{
    use PropertyControllerTrait;

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(RewardCrudController::class)->generateUrl());

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

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Project');
    }

    public function configureMenuItems(): iterable
    {
        $entities = new TranslatableMessage('menu.extendable-entities', [], 'LongitudeOnePropertyBundle');
        yield MenuItem::linkToRoute($entities, 'fa-solid fa-wand-magic-sparkles', 'longitudeone_property_extendable_entities_list');
        yield MenuItem::linkToCrud('Custom properties', 'fas fa-list', Definition::class);
        yield MenuItem::linkToCrud('The Reward', 'fas fa-list', Reward::class);
    }
}
