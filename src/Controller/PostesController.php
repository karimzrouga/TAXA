<?php

namespace App\Controller;

use App\Entity\Postes;
use App\Form\PostesType;
use App\Repository\PostesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/postes")
 */
class PostesController extends AbstractController
{
    /**
     * @Route("/", name="postes_index", methods={"GET"})
     */
    public function index(PostesRepository $postesRepository): Response
    {
        return $this->render('postes/index.html.twig', [
            'postes' => $postesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="postes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $poste = new Postes();
        $form = $this->createForm(PostesType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($poste);
            $entityManager->flush();

            return $this->redirectToRoute('postes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('postes/new.html.twig', [
            'poste' => $poste,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="postes_show", methods={"GET"})
     */
    public function show(Postes $poste): Response
    {
        return $this->render('postes/show.html.twig', [
            'poste' => $poste,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="postes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Postes $poste, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostesType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('postes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('postes/edit.html.twig', [
            'poste' => $poste,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="postes_delete", methods={"POST"})
     */
    public function delete(Request $request, Postes $poste, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$poste->getId(), $request->request->get('_token'))) {
            $entityManager->remove($poste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('postes_index', [], Response::HTTP_SEE_OTHER);
    }
}
