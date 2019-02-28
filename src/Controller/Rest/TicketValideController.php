<?php

namespace App\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TicketValide;
use App\Raffinage\TicketValideRaffinage;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\View(serializerGroups={"ticketvalide"})
 */
class TicketValideController extends FOSRestController
{
    /**
     * @Rest\Get("/tickets-valide/remove/{id}", requirements={"id": "\d+"})
     */
    public function removeTicketValide($id)
    {
        $response = array();
        if( intval($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $TicketValide = $entityManager->getRepository(TicketValide::class)->find($id);
            $entityManager->remove($TicketValide);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }


    /**
     * @Rest\Get("/tickets-valide/{id}", requirements={"id": "\d+"})
     */
    public function findOneTicketValide($id)
    {
        $response = array();
        if( intval($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $TicketValide = $entityManager->getRepository(TicketValide::class)->find($id);
            $response = TicketValideRaffinage::removeCircular($TicketValide);
        }else $response = array("status"=>"error");
        
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/tickets-valide")
     */
    public function TicketValide()
    {
        $allClis = $this->getDoctrine()->getRepository(TicketValide::class)->findAll();
        $response = TicketValideRaffinage::removeAllCircular($allClis);
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view); 
    }

}
