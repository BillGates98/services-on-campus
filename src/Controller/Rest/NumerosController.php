<?php

namespace App\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Numeros;
use App\Entity\Client;
use App\Raffinage\NumerosRaffinage;


use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\View(serializerGroups={"numeros"})
 */
class NumerosController extends FOSRestController
{

    /**
     * @Rest\Get("/numeros/add/{idclient}/{operateur}/{numero}")
     */
    public function addNumeros($idclient,$operateur,$numero)
    {
        $response = array();
        if( intval($idclient) > 0 && strlen($operateur) > 0 && strlen($numero) > 0) // doit etre verifier avec une expression reguliere
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $client = $entityManager->getRepository(Client::class)->find($idclient);
            
            $Numeros = (new Numeros())->setOperateur( $operateur )->setNumero( $numero )
                                        ->setClient($client);
            
            $entityManager->persist($Numeros);
            $entityManager->flush();
            $response = array("status"=>"ok");
        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
        
    }

    /**
     * @Rest\Get("/numeros/update/{id}/{operateur}/{numero}")
     */
    public function updateNumeros($id,$operateur,$numero)
    {
        $response = array();
        if(  intval($id) > 0 && strlen($operateur) > 0 && strlen($numero) > 0 )
        {
            $entityManager = $this->getDoctrine()->getManager();

            $Numeros = $entityManager->getRepository(Numeros::class)
                        ->find($id)->setOperateur($operateur)->setNumero($numero);

            $entityManager->persist($Numeros);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
        
    }

    /**
     * @Rest\Get("/numeros/remove/{id}", requirements={"id": "\d+"})
     */
    public function removeNumeros($id)
    {
        $response = array();
        if( intval($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $Numeros = $entityManager->getRepository(Numeros::class)->find($id);
            $entityManager->remove($Numeros);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }


    /**
     * @Rest\Get("/numeros/{id}", requirements={"id": "\d+"})
     */
    public function findOneNumeros($id)
    {
        $response = array();
        if( intval($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $Numeros = $entityManager->getRepository(Numeros::class)->findAllNumbers($id);
            $response = NumerosRaffinage::removeAllCircular($Numeros);
        }else $response = array("status"=>"error");
        
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/numeros")
     */
    public function Numeros()
    {
        $allClis = $this->getDoctrine()->getRepository(Numeros::class)->findAll();
        $response = NumerosRaffinage::removeAllCircular($allClis);
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view); 
    }

}
