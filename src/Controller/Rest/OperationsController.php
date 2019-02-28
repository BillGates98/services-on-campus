<?php

namespace App\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Admin;
use App\Entity\Operations;
use App\Entity\Client;
use App\Entity\Produit;
use App\Entity\TicketValide;
use App\Raffinage\OperationsRaffinage;
use App\Raffinage\TicketValideRaffinage;


use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\View(serializerGroups={"operations"})
 */
class OperationsController extends FOSRestController
{

    /**
     * @Rest\Get("operations/add/{idclient}/{idproduit}/{quantite}/{numero}")
     */
    public function addOperation($idclient,$idproduit,$quantite,$numero)
    {
        $response = array();
        if( intval($idclient) > 0 && intval($idproduit) > 0 && intval($quantite) > 0 )
        {   
            $entityManager = $this->getDoctrine()->getManager();

            $client = $entityManager->getRepository(Client::class)->find($idclient);
            $produit = $entityManager->getRepository(Produit::class)->find($idproduit);
            
            $montant = intval($quantite*$produit->getPrix())%100;
            $code = TicketValideRaffinage::makePaiement($numero,$montant);

            if( strlen( trim($code) ) > 0  )
            {
                $ticketValide = (new TicketValide())->setCode( $code )->setStatut(0);
                
                $entityManager->persist($ticketValide);

                $operation = (new Operations())->setQuantite($quantite)->setMontant( ($quantite*$produit->getPrix()) )
                ->setJour( date('d') )->setMois( date('m') )->setAnnee( date('Y') )->setHeure( date('H') )
                ->setMinute( date('i') )->setClient( $client )->setProduit( $produit )
                ->setTicketValide( $ticketValide );

                $entityManager->persist($operation);
                $entityManager->flush();
                $response = array("status"=>"ok");
            }else {
                $response = array("status"=>"insuffisient");
            }
        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
        
    }

    /**
     * @Rest\Get("/operations/remove/{id}", requirements={"id": "\d+"})
     */
    public function removeOperations($id)
    {
        $response = array();
        if( intval($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $operation = $entityManager->getRepository(Operations::class)->find($id);
            $entityManager->remove($operation);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }
    /**
     * @Rest\Get("/operations/client/{id}")
     */
    public function operationsForClient($id)
    {
        $response = array();
        if( intval($id) > 0 ) 
        {   
            $allOps = $this->getDoctrine()->getRepository(Operations::class)->findByClient($id);
            $response = OperationsRaffinage::removeAllCircular($allOps);
        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view); 
    }

    /**
     * @Rest\Get("/operations")
     */
    public function operations()
    {
        $allOps = $this->getDoctrine()->getRepository(Operations::class)->findAll();
        $response = OperationsRaffinage::removeAllCircular($allOps);
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view); 
    }

}
