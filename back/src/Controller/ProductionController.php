<?php

namespace App\Controller;

use App\Entity\Production;
use App\Form\ProductionType;
use App\Repository\ProductionRepository;
use App\Service\ProductionRetrievalService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/productions')]
class ProductionController extends AbstractController
{
    #[Route('/', name: 'app_production_index', methods: ['GET'])]
    public function index(ProductionRepository $productionRepository): Response
    {
        return $this->render('production/index.html.twig', [
            'productions' => $productionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_production_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductionRetrievalService $productionRetrievalService, ProductionRepository $productionRepository): Response
    {
        $production = new Production();
        $form = $this->createForm(ProductionType::class, $production);
        $form->handleRequest($request);

        /* if ($form->isSubmitted() && $form->isValid()) {
            $productionRepository->save($production, true);

            return $this->redirectToRoute('app_production_index', [], Response::HTTP_SEE_OTHER);
        } */

        if ($form->isSubmitted() && $form->isValid()) {

            $title = $form->get('title')->getData();

            $searchResults = $productionRetrievalService->search($title);

            return $this->renderForm('production/new.html.twig', [
                'production' => $production,
                'form' => $form,
                'searchResults' => $searchResults,
            ]);
        }

        return $this->renderForm('production/new.html.twig', [
            'production' => $production,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_production_show', methods: ['GET'])]
    public function show(Production $production): Response
    {
        return $this->render('production/show.html.twig', [
            'production' => $production,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_production_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Production $production, ProductionRepository $productionRepository): Response
    {
        $form = $this->createForm(ProductionType::class, $production);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productionRepository->save($production, true);

            return $this->redirectToRoute('app_production_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('production/edit.html.twig', [
            'production' => $production,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_production_delete', methods: ['POST'])]
    public function delete(Request $request, Production $production, ProductionRepository $productionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $production->getId(), $request->request->get('_token'))) {
            $productionRepository->remove($production, true);
        }

        return $this->redirectToRoute('app_production_index', [], Response::HTTP_SEE_OTHER);
    }
}