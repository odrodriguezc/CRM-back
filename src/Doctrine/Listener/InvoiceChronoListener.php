<?php

namespace App\Doctrine\Listener;

use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;


class InvoiceChronoListener
{
    protected InvoiceRepository $repository;

    public function __construct(InvoiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function prePersist(Invoice $invoice)
    {
        if ($invoice->getChrono()) {
            return;
        }

        $lastChrono = $this->repository->findlastChrono();
        $invoice->setChrono($lastChrono + 1);
    }
}
