<?php

namespace App\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Raffinage\ClientRaffinage;


use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\View(serializerGroups={"clients"})
 */
class ClientController extends FOSRestController
{

    /**
     * @Rest\Get("/clients/add/{matricule}/{password}")
     */
    public function addClient($matricule,$password)
    {
        $response = array();
        $pwd = trim($password);
        if( strlen($pwd) > 0 && ClientRaffinage::checkMatricule($matricule) ) // doit etre verifier avec une expression reguliere
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $client = (new Client())->setMatricule( $matricule )->setPassword( md5(password_hash($pwd,PASSWORD_ARGON2I,["cost"=>50,]) ) );
            $entityManager->persist($client);
            $entityManager->flush();
            $response = array("status"=>"ok");
        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
        
    }

    /**
     * @Rest\Get("/clients/update/{id}/{matricule}/{password}")
     */
    public function updateClient($id,$matricule,$password)
    {
        $response = array();
        if(  intval($id) > 0 && strlen($matricule) > 0 && strlen($password) > 0 )
        {
            $entityManager = $this->getDoctrine()->getManager();

            $client = $entityManager->getRepository(Client::class)
                        ->find($id)->setMatricule($matricule)->setPassword( $password );

            $entityManager->persist($client);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
        
    }

    /**
     * @Rest\Get("/clients/remove/{id}", requirements={"id": "\d+"})
     */
    public function removeClient($id)
    {
        $response = array();
        if( intval($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $client = $entityManager->getRepository(Client::class)->find($id);
            $entityManager->remove($client);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }


    /**
     * @Rest\Get("/clients/{id}", requirements={"id": "\d+"})
     */
    public function findOneClient($id)
    {
        $response = array();
        if( intval($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $client = $entityManager->getRepository(Client::class)->find($id);
            $response = ClientRaffinage::removeCircular($client);
        }else $response = array("status"=>"error");
        
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/clients")
     */
    public function clients()
    {
        $allClis = $this->getDoctrine()->getRepository(Client::class)->findAll();
        $response = ClientRaffinage::removeAllCircular($allClis);
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view); 
    }

}
