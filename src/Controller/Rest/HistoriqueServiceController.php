<?php

namespace App\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Admin;
use App\Entity\HistoriqueService;
use App\Entity\Service;
use App\Raffinage\HistoriqueServiceRaffinage;


use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\View(serializerGroups={"historique_services"})
 */
class HistoriqueServiceController extends FOSRestController
{

    /**
     * @Rest\Get("/historique-services/{id}")
     */
    public function findOneHistoriqueService($id)
    {
        $response = array();
        if( intval($id) > 0  )
        {
            $Hsvc = $this->getDoctrine()->getRepository(HistoriqueService::class)->findById($id);
            $response = HistoriqueServiceRaffinage::removeAllCircular($Hsvc);
        }else $response = array("status"=>"error");

        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view); 
    }

    /**
     * @Rest\Get("/historique-services")
     */
    public function historiqueService()
    {
        $allHsvc = $this->getDoctrine()->getRepository(HistoriqueService::class)->findAll();
        $response = HistoriqueServiceRaffinage::removeAllCircular($allHsvc);
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view); 
    }

}
