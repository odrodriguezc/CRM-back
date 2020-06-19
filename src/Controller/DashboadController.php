<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use App\Repository\InvoiceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboadController extends AbstractController
{
    /**
     * @Route("/", name="dashboad")
     */
    public function index(UserRepository $userRepository, InvoiceRepository $invoiceRepository, CustomerRepository $customerRepository)
    {
        $invoices = $invoiceRepository->count([]);
        $customers = $customerRepository->count([]);
        $users = $userRepository->count([]);

        return $this->render('dashboad/index.html.twig', [
            'invoices' => $invoices,
            'customers' => $customers,
            'users' => $users
        ]);
    }
}
