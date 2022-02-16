<?php

namespace App\Controller;

use App\Entity\Postes;
use App\Form\UserType;
use App\Form\PostesType;
use App\Repository\UserRepository;
use App\Repository\PostesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{add}", name="blog")
     */
    public function index( $add,SluggerInterface $slugger ,Request $request,UserRepository $Userrepo,ManagerRegistry $doctrine,PostesRepository $PRepo,AuthenticationUtils $authenticationUtils): Response
    {  
        $postes=$PRepo->findAll();
        if ($add=="true")
        
        { 
            $lastUsername = $authenticationUtils->getLastUsername();
             if($lastUsername ){
            $user=$Userrepo->findByusername($lastUsername);
            $post=new Postes();
            $form = $this->createForm(PostesType::class, $post);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->getData()->getImage()!==null&& $form->getData()->getDescription()!==null) {
            $post=$form->getData();
            $uploadedFile = $form->get('image')->getData();
            $originalFilename = pathinfo($uploadedFile ->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
            try {
                $uploadedFile->move(
                    $this->getParameter('brochures_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
            }
            $post->setImage($newFilename);
            $post->setUser($user);
            $user->addListpost($post);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
            $postes=$PRepo->findAll();
            
            return $this->renderForm('blog/blog.html.twig', [
                "postes" => $postes,"add"=>false,"form"=>$form,
            ]);  
            }
            return $this->renderForm('blog/blog.html.twig', [
                "postes" => $postes,"add"=>true,"form"=>$form,
            ]);  
        }
        else{
            return $this->redirectToRoute('app_login');
        }
        }
    
      
        else{
            return $this->render('blog/blog.html.twig', [
                "postes" => $postes,"add"=>false
            ]);
        }
       
    }
}
