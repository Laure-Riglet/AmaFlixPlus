<?php

namespace App\Controller;

use App\Entity\Production;
use App\Form\ProductionType;
use App\Repository\ProductionRepository;
use App\Service\ProductionRetrievalService;
use App\Service\TextFormatService;
use DateTime;
use DateTimeImmutable;
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
        $title = $request->request->get('title');

        if ($title) {
            $searchResults = $productionRetrievalService->search($title);
            return $this->renderForm('production/new.html.twig', [
                'searchResults' => $searchResults,
            ]);
        }

        return $this->render('production/new.html.twig');
    }

    #[Route('/add', name: 'app_production_add', methods: ['GET', 'POST'])]
    public function add(
        Request $request,
        TextFormatService $TextFormatService,
        ProductionRepository $productionRepository
    ): Response {
        $selectedProduction = $request->request->get('selected_production');
        $production = new Production();
        if (isset($selectedProduction['title'])) {
            $production->setTitle($selectedProduction['title'])
                ->setOriginalTitle($selectedProduction['original_title'])
                ->setSlug($TextFormatService->slugify($selectedProduction['title']))
                ->setImdbId($selectedProduction['imdb_id'] ?? 'test')
                ->setType($selectedProduction['media_type'] === 'movie' ? 'Film' : 'Série')
                ->setReleaseDate(new DateTime($selectedProduction['release_date']))
                ->setDuration($selectedProduction['duration'] ?? 77)
                ->setTagline($selectedProduction['tagline'] ?? 'test')
                ->setSynopsis($selectedProduction['summary'])
                ->setRating($selectedProduction['rating'] ?? 0.1)
                ->setPoster($selectedProduction['poster_path'] ?? 'test')
                ->setBackdrop($selectedProduction['backdrop_path'] ?? 'test')
                ->setTrailer($selectedProduction['trailer'] ?? 'test');
        }

        $form = $this->createForm(ProductionType::class, $production);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productionRepository->save($production, true);

            return $this->redirectToRoute('app_production_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('production/add.html.twig', [
            'production' => $production,
            'selectedProduction' => $selectedProduction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/medias', name: 'app_production_medias', methods: ['POST'])]
    public function medias(Request $request, Production $production, ProductionRepository $productionRepository): Response
    {
        $medias = $request->request->all();
        //$production->setMedias($medias);
        $productionRepository->save($production, true);

        return $this->redirectToRoute('app_production_index', [], Response::HTTP_SEE_OTHER);
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