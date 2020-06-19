<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customers", name="customer_index")
     */
    public function index(CustomerRepository $customerRepository)
    {
        return $this->render('customer/index.html.twig', [
            'customers' => $customerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/customers/delete/{id<\d+>}", name="customer_delete" )
     */
    public function delete(Customer $customer, EntityManagerInterface $em)
    {
        $em->remove($customer);
        $em->flush();

        return $this->redirectToRoute('customer_index');
    }


    /**
     * @Route("/customers/edit/{id<\d+>}", name="customer_edit" )
     */
    public function edit(Customer $customer, EntityManagerInterface $em, Request $request)
    {

        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $customer = $form->getData();
            $em->flush();

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
