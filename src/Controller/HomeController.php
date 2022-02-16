<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\TripRepository;
use App\Repository\PlaceRepository;
use App\Repository\PostesRepository;
use App\Repository\AdventureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(PostesRepository $postRepo ,TripRepository $tripRepo,AdventureRepository $AdventureRepo,PlaceRepository $placeRepo): Response
    {   $listpost=$postRepo->findAll();
        $listtrip=$tripRepo->findAll();
        $listAdventure=$AdventureRepo->findAll();
        $listplace=$placeRepo->findAll();
        return $this->render('home/home.html.twig', [
            'trips' =>$listtrip ,'adventure' =>$listAdventure,'places' =>$listplace ,"blogs"=>$listpost]);
    }
    
    /**
     * @Route("/contact", name="contact" , methods={"GET", "POST"})
     */
    public function contact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();
            return $this->redirectToRoute('home');

          
        }

        return $this->renderForm('home/contact/contact.html.twig', [
            
            'form' => $form,
        ]);
    }
    
}
