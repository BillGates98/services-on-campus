<?php

namespace App\Controller\Rest;

use App\Entity\Admin;
use App\Raffinage\AdminRaffinage;
use App\Entity\Service;
use App\Repository\AdminRepository;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\View(serializerGroups={"admins"})
 */
class AdminController extends FOSRestController
{

    /**
     * @var AdminRepository
     */
    private $rp;

    public function __construct(AdminRepository $sar)
    {
       $this->rp = $sar;
    }

    /**
     * @Rest\Get("/admins/add/{login}/{password}/{service}/{validite}")
     */
    public function addAdmin($login,$password,$service,$validite)
    {
        $response = array();
        if( strlen($login) > 0 && strlen($password) > 0 && strlen($service) > 0 && strlen($validite) > 0 )
        {
            
            $service = (new Service())->setNomService($service)->setValidite($validite);

            $admin = (new Admin())->setLogin($login)
                                  ->setPassword($password)
                                  ->setService($service);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($service);
            $entityManager->persist($admin);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
        
    }

    /**
     * @Rest\Get("/admins/update/{id}/{login}/{password}/{service}/{validite}")
     */
    public function updateAdmin($id,$login,$password,$service,$validite)
    {
        $response = array();
        if( strlen($id) > 0 && strlen($login) > 0 && strlen($password) > 0 && strlen($service) > 0 && strlen($validite) > 0 )
        {
            $entityManager = $this->getDoctrine()->getManager();
            $admin = $entityManager->getRepository(Admin::class)->find($id);

            $admin->setLogin( $login )->setPassword( $password );
            $serviceObject = $admin->getService();
            $serviceObject->setNomService( $service );
            $serviceObject->setValidite( $validite );

            $admin->setService( $serviceObject );
            
            $entityManager->persist( $serviceObject );
            $entityManager->persist( $admin );
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
        
    }

    /**
     * @Rest\Get("/admins/remove/{id}", requirements={"id": "\d+"})
     */
    public function removeAdmin($id)
    {
        $response = array();
        if( strlen($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $admin = $entityManager->getRepository(Admin::class)->find($id);
            $entityManager->remove($admin);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }


    /**
     * @Rest\Get("/admins/{id}", requirements={"id": "\d+"})
     */
    public function findOneAdmin($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $admin = $entityManager->getRepository(Admin::class)->find($id);
        $admin->setService( AdminRaffinage::removeCircular($admin) );
        $view = $this->view($admin, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/admins")
     */
    public function Administrators()
    {
        $allAdmins = $this->getDoctrine()->getRepository(Admin::class)->findAll();
        $reponse = AdminRaffinage::removeAllCircular($allAdmins);
        $view = $this->view($reponse, Response::HTTP_OK);
        return $this->handleView($view); 
    }

}
