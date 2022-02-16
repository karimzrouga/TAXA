<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\TripRepository;
use App\Repository\UserRepository;
use App\Repository\AdventureRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{   



    /**
     * @Route("detail/{id}", name="reservation_detail", methods={"GET", "POST"}))
     */
    public function reservation_detail($id ,TripRepository $TripRepo) : Response
    {    $selectedtrip=  $TripRepo->find($id);
       
        return $this->renderForm('home/reservation/clientnewres.html.twig', [
            'restrip' => $selectedtrip ,'newres' => null
            
        ]);
    }
     
    /**
     * @Route("advdetail/{id}", name="advreservation_detail", methods={"GET", "POST"}))
     */
    public function reservationadv_detail($id ,AdventureRepository $advRepo) : Response
    {    $selectedadv=  $advRepo->find($id);
       
        return $this->renderForm('home/reservation/clientnewresadv.html.twig', [
            'resadv' => $selectedadv ,'newres' => null
            
        ]);
    }
    /**
     * @Route("makereservation/{id}/{type}", name="makereservation", methods={"GET", "POST"}))
     */
    public function makereservation($id,$type,TripRepository $TripRepo,AdventureRepository $advRepo ,AuthenticationUtils $authenticationUtils, UserRepository $Userrepo,ManagerRegistry $doctrine) : Response
    {    
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
if ($lastUsername)
{   
    if ($type=="trip")
    {
        $selectedtrip=  $TripRepo->find($id);
        $newres = new Reservation();
        $newres->setTrip($selectedtrip);
        $newres->setDate(new \DateTime('now'));
        $user=$Userrepo->findByusername($lastUsername);
        $user->addReservation( $newres );
        $newres->setUser( $user);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($newres);
        $entityManager->flush();
        return $this->renderForm('home/reservation/clientnewres.html.twig', [
            'username' => $user->getFullname(),  'newres' => $newres ,'restrip' => null]);
       }
   
    else{
        $selectedadv=  $advRepo ->find($id);
        $newres = new Reservation();
        $newres->setAdventure($selectedadv);
        $newres->setDate(new \DateTime('now'));
        $user=$Userrepo->findByusername($lastUsername);
        $user->addReservation( $newres );
        $newres->setUser( $user);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($newres);
        $entityManager->flush();
        return $this->renderForm('home/reservation/clientnewresadv.html.twig', [
            'username' => $user->getFullname(),  'resadv' => null ,'newres' =>$newres]);
       }
    }
 
else{
    return $this->redirectToRoute('app_login', ['last_username' => $lastUsername, 'error' => $error]);
  
}
   
    }
    /**
     * @Route("/", name="reservation_index", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reservation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
