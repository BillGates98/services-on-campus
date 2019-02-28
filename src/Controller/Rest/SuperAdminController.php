<?php

namespace App\Controller\Rest;

use App\Repository\SuperAdminRepository;
use App\Entity\SuperAdmin;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\View(serializerGroups={"super_admins"})
 */
class SuperAdminController extends FOSRestController
{
    /**
     * @var SuperAdminRepository
     */
    private $rp;
    
    public function __construct(SuperAdminRepository $sar)
    {
       $this->rp = $sar;
    }

        /**
     * @Rest\Get("/super-admins/add/{login}/{password}")
     */
    public function addSuperAdmin($login,$password)
    {
        $response = array();
        if( strlen($login) > 0 && strlen($password) > 0 )
        {
            
            $superAdmin = (new SuperAdmin())->setLogin($login)
                                  ->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($superAdmin);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
        
    }

    /**
     * @Rest\Get("/super-admins/update/{id}/{login}/{password}")
     */
    public function updateSuperAdmin($id,$login,$password)
    {
        $response = array();
        if( strlen($id) > 0 && strlen($login) > 0 && strlen($password) > 0 )
        {
            $entityManager = $this->getDoctrine()->getManager();
            $superAdmin = $entityManager->getRepository(SuperAdmin::class)->find($id);
            $superAdmin->setLogin( $login )->setPassword( $password );

            $entityManager->persist( $superAdmin );
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
        
    }

    /**
     * @Rest\Get("/super-admins/remove/{id}", requirements={"id": "\d+"})
     */
    public function removeSuperAdmin($id)
    {
        $response = array();
        if( strlen($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $superAdmin = $entityManager->getRepository(SuperAdmin::class)->find($id);
            $entityManager->remove($superAdmin);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }


    /**
     * @Rest\Get("/super-admins/{id}", requirements={"id": "\d+"})
     */
    public function findOneSuperAdmin($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $superAdmin = $entityManager->getRepository(SuperAdmin::class)->find($id);
        $view = $this->view($superAdmin, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/super-admins")
     */
    public function superAdministrators()
    {
        $allSuperAdmins = $this->getDoctrine()->getRepository(SuperAdmin::class)->findAll();
        $view = $this->view($allSuperAdmins, Response::HTTP_OK);
        return $this->handleView($view); 
    }
}
