<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Enum\InvoiceStatus;
use App\Repository\ProductRepository;
use App\Entity\InvoiceItem;



#[Route('/invoice')]
final class InvoiceController extends AbstractController
{
    #[Route(name: 'app_invoice_index', methods: ['GET'])]
    public function index(InvoiceRepository $invoiceRepository): Response
    {
        return $this->render('invoice/index.html.twig', [
            'invoices' => $invoiceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_invoice_new', methods: ['GET', 'POST'])]
    public function new(ProductRepository $productRepository, Request $request, EntityManagerInterface $entityManager ,InvoiceRepository $invoiceRepository): Response
    {

        $invoice = new Invoice();
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ownerを設定
            $invoice->setOwner($this->getUser());
            // statusをbrouillonに設定
            $invoice->setStatus(InvoiceStatus::DRAFT);
            // 作成日を設定
            $invoice->setCreatedAt(new \DateTime());
            
            // 番号を自動生成（後で実装）
            $now = new \DateTime();
            $count = $invoiceRepository->countByMonth($now);
            $invoice->setNumber('FACT-' . $now->format('Ymd') . '-' . ($count + 1));

            // ボタンの種類を確認（draft or validate）
            $action = $request->request->get('action');
            // statusを設定 
            if ($action === 'validate') {
                $invoice->setStatus(InvoiceStatus::PENDING_PAYMENT);
            } else {
                $invoice->setStatus(InvoiceStatus::DRAFT);
            }
            $lines = $request->request->all('lines');

            foreach ($lines as $lineData) {
                $product = $productRepository->find($lineData['productId']);
                $item = new InvoiceItem();
                $item->setProduct($product);
                $item->setQuantity((int)$lineData['quantity']);
                $item->setUnitPrice((float)$lineData['unitPrice']);
                $item->setInvoice($invoice);
                $entityManager->persist($item);
            }

            $total = array_sum(array_map(function ($lineData) {
                return $lineData['quantity'] * $lineData['unitPrice'];
            }, $lines));
            $invoice->setTotalTtc($total);
            $entityManager->persist($invoice);
            $entityManager->flush();

            return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('invoice/new.html.twig', [
            'invoice' => $invoice,
            'form' => $form,
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_invoice_show', methods: ['GET'])]
    public function show(Invoice $invoice): Response
    {
        return $this->render('invoice/show.html.twig', [
            'invoice' => $invoice,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_invoice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Invoice $invoice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('invoice/edit.html.twig', [
            'invoice' => $invoice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_invoice_delete', methods: ['POST'])]
    public function delete(Request $request, Invoice $invoice, EntityManagerInterface $entityManager): Response
    {
        if ($invoice->getStatus() !== InvoiceStatus::DRAFT) {
            $this->addFlash('error', 'Une facture validée ne peut pas être supprimée.');
            return $this->redirectToRoute('app_invoice_index');
        }


        if ($this->isCsrfTokenValid('delete' . $invoice->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($invoice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
    }
}
