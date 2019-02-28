<?php

namespace App\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Service;
use App\Entity\Categories0;
use App\Raffinage\Categories0Raffinage;


use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\View(serializerGroups={"categories0"})
 */
class Categories0Controller extends FOSRestController
{

    /**
     * @Rest\Get("/categories0/add/{idservice}/{libelle}")
     */
    public function addCategories0($idservice,$libelle)
    {
        $response = array();
        if( intval($idservice) > 0 && strlen($libelle) > 0 )
        {   
            $entityManager = $this->getDoctrine()->getManager();

            $categories0 = (new Categories0())->setLibelle($libelle);
            $entityManager->persist($categories0);

            $service = $entityManager->getRepository(Service::class)->find($idservice);
            $service->addCategories0( $categories0 );

            $entityManager->persist($service);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
        
    }

    /**
     * @Rest\Get("/categories0/update/{id}/{libelle}")
     */
    public function updateCategories0($id,$libelle)
    {
        $response = array();
        if(  intval($id) > 0 && strlen($libelle) > 0 )
        {
            $entityManager = $this->getDoctrine()->getManager();
            $categories0 = $entityManager->getRepository(Categories0::class)->find($id);
            $categories0->setLibelle($libelle);
            $entityManager->persist($categories0);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
        
    }

    /**
     * @Rest\Get("/categories0/remove/{id}", requirements={"id": "\d+"})
     */
    public function removeCategories0($id)
    {
        $response = array();
        if( intval($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $categories0 = $entityManager->getRepository(Categories0::class)->find($id);
            $entityManager->remove($categories0);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }


    /**
     * @Rest\Get("/categories0/{id}", requirements={"id": "\d+"})
     */
    public function findOneCategories0($id)
    {
        $response = array();
        if( intval($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $categories0 = $entityManager->getRepository(Categories0::class)->find($id);
            $categories0->setService( Categories0Raffinage::removeCircular($categories0) );
            $response = $categories0;
        }else $response = array("status"=>"error");
        
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/categories0")
     */
    public function categories0()
    {
        $allCats0 = $this->getDoctrine()->getRepository(Categories0::class)->findAll();
        $reponse = Categories0Raffinage::removeAllCircular($allCats0);
        $view = $this->view($reponse, Response::HTTP_OK);
        return $this->handleView($view); 
    }
    
}
