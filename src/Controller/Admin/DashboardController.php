<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SymCRM');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Clients', 'fa fa-folder', Customer::class);
        yield MenuItem::linkToCrud('Factures', 'fa fa-credit-card', Invoice::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class);
    }
}
