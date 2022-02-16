<?php

namespace App\Controller;

use App\Entity\Adventure;
use App\Form\AdventureType;
use App\Repository\AdventureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adventure")
 */
class AdventureController extends AbstractController
{

    /**
     * @Route("/all", name="adventures_index", methods={"GET"})
     */
    public function indexadventures(AdventureRepository $adventureRepository): Response
    {
        return $this->render('home/adventures/adventures.html.twig', [
            'adventures' => $adventureRepository->findAll(),
        ]);
    }
    /**
     * @Route("/detail/{id}", name="adv_detail", methods={"GET"})
     */
    public function trip_detail($id ,AdventureRepository $adventureRepository): Response
    {
        $selectedadv=  $adventureRepository->find($id);
        return $this->render('home/adventures/adventuresdetail.html.twig', [
            'adv' => $selectedadv,
        ]);
    }


    /**
     * @Route("/", name="adventure_index", methods={"GET"})
     */
    public function index(AdventureRepository $adventureRepository): Response
    {
        return $this->render('adventure/index.html.twig', [
            'adventures' => $adventureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="adventure_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $adventure = new Adventure();
        $form = $this->createForm(AdventureType::class, $adventure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($adventure);
            $entityManager->flush();

            return $this->redirectToRoute('adventure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adventure/new.html.twig', [
            'adventure' => $adventure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="adventure_show", methods={"GET"})
     */
    public function show(Adventure $adventure): Response
    {
        return $this->render('adventure/show.html.twig', [
            'adventure' => $adventure,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="adventure_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Adventure $adventure, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdventureType::class, $adventure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('adventure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adventure/edit.html.twig', [
            'adventure' => $adventure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="adventure_delete", methods={"POST"})
     */
    public function delete(Request $request, Adventure $adventure, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adventure->getId(), $request->request->get('_token'))) {
            $entityManager->remove($adventure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('adventure_index', [], Response::HTTP_SEE_OTHER);
    }
}
