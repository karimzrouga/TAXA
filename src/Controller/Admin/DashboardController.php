<?php

namespace App\Controller\Admin;

use App\Entity\Trip;
use App\Entity\User;
use App\Entity\Hotel;
use App\Entity\Place;
use App\Entity\Client;
use App\Entity\Postes;
use App\Entity\Contact;
use App\Entity\Adventure;
use App\Entity\Reservation;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{   

   
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {   
       
            return parent::index();
   
            $routeBuilder = $this->get(AdminUrlGenerator::class);
             $url = $routeBuilder->setController(ConferenceCrudController::class)->generateUrl();
         
             return $this->redirect($url);
        
    }
    


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TAXA');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters):QueryBuilder {
        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        return $response;
    }
    public function configureMenuItems(): iterable
    {
        return [

            MenuItem::linkToDashboard('Profile ', 'fa fa-user')->setPermission('ROLE_Admin'),
            MenuItem::linkToCrud('Client', 'fas fa-users', User::class)->setPermission('ROLE_Admin'),
            MenuItem::linkToCrud('Hotel', 'fas fa-hotel', Hotel::class)->setPermission('ROLE_Admin'),
            MenuItem::linkToCrud('Trip', 'fa fa-plane', Trip::class)->setPermission('ROLE_Admin'),
            MenuItem::linkToCrud('Adventure', 'fas fa-hiking', Adventure::class)->setPermission('ROLE_Admin'),
            MenuItem::linkToCrud('Place', 'fas fa-map-marked-alt', Place::class)->setPermission('ROLE_Admin'),
            MenuItem::linkToCrud('Reservation ', 'fas fa-user-check', Reservation::class)->setPermission('ROLE_Admin'),
            MenuItem::linkToCrud('Postes ', 'fas  fa-mail-bulk', Postes::class)->setPermission('ROLE_Admin'),
            MenuItem::linkToCrud('Contact ', 'fas  fa-inbox', Contact::class)->setPermission('ROLE_Admin'),
            MenuItem::linktoRoute('Back to TAXA', 'fas fa-home','home'),
           
        ];
    }
}
