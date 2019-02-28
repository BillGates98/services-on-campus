<?php

namespace App\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Admin;
use App\Entity\HistoriqueProduit;
use App\Entity\Produit;
use App\Raffinage\HistoriqueProduitRaffinage;


use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\View(serializerGroups={"historique_produits"})
 */
class HistoriqueProduitController extends FOSRestController
{

    /**
     * @Rest\Get("/historique-produits/{id}")
     */
    public function findOneHistoriqueProduit($id)
    {
        $response = array();
        if( intval($id) > 0  )
        {
            $Hsvc = $this->getDoctrine()->getRepository(HistoriqueProduit::class)->findById($id);
            $response = HistoriqueProduitRaffinage::removeAllCircular($Hsvc);
        }else $response = array("status"=>"error");

        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view); 
    }


    /**
     * @Rest\Get("/historique-produits/{id}/produits")
     */
    public function findHistoriqueProduits($id)
    {
        $response = array();
        if( intval($id) > 0  )
        {
            $Hsvc = $this->getDoctrine()->getRepository(HistoriqueProduit::class)->findTrackProductById($id);
            $response = HistoriqueProduitRaffinage::removeAllCircular($Hsvc);
        }else $response = array("status"=>"error");

        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view); 
    }

    /**
     * @Rest\Get("/historique-produits")
     */
    public function historiqueProduit()
    {
        $allHsvc = $this->getDoctrine()->getRepository(HistoriqueProduit::class)->findAll();
        $response = HistoriqueProduitRaffinage::removeAllCircular($allHsvc);
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view); 
    }

}
