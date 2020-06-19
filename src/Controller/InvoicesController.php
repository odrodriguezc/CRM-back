<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InvoicesController extends AbstractController
{
    /**
     * @Route("/invoices", name="invoices_index")
     */
    public function index(InvoiceRepository $invoiceRepository)
    {
        return $this->render('invoices/index.html.twig', [
            'invoices' => $invoiceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/invoices/edit/{id<\d+>}", name="invoices_edit")
     */
    public function edit(Request $request, Invoice $invoice, EntityManagerInterface $em)
    {
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $invoice = $form->getData();
            $em->flush();

            return $this->redirectToRoute('invoices_index');
        }

        return $this->render('invoices/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/invoices/delete/{id<\d+>}", name="invoices_delete" )
     */
    public function delete(Invoice $invoice, EntityManagerInterface $em)
    {
        $em->remove($invoice);
        $em->flush();

        return $this->redirectToRoute('invoices_index');
    }
}
