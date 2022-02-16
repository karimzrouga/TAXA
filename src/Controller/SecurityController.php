<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {  //$this->redirectToRoute('home');
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
       
    }
     /**
     * @Route("/lisLoggedIn", name="app_isLoggedIn")
     */
    public function isLoggedIn(AuthenticationUtils $authenticationUtils)
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($lastUsername)
        {
            return $this->render('base.html.twig', ['isLoggedIn' => true]);
        }
        else{
            return $this->render('base.html.twig', ['isLoggedIn' => false]);
        }
       
    }


  //  /**
  //   * @Route("/profile", name="app_profile")
  //   */
    /*
    public function profile(AuthenticationUtils $authenticationUtils ,UserRepository $Userrepo)
    {    
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($lastUsername )
        {
            $user=$Userrepo->findByusername($lastUsername);
            $reservation=$user->getReservation();
            //$trips=$reservation->getTrip();
           // $adventures=$user->getReservation()->getAdventure();
            return $this->render('profile/profile.html.twig', ['user' =>  $user ]);
        }else
        {
            return $this->redirectToRoute('app_login');

        }
        
    }*/


}
