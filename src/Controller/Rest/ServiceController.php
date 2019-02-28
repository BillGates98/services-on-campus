<?php

namespace App\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Admin;
use App\Entity\Service;
use App\Entity\HistoriqueService;
use App\Entity\Categories;
use App\Raffinage\ServicesRaffinage;


use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\View(serializerGroups={"services"})
 */
class ServiceController extends FOSRestController
{

    /**
     * @Rest\Get("/services/add/{idadmin}/{nomservice}/{validite}")
     */
    public function addService($idadmin,$nomservice,$validite)
    {
        $response = array();
        if( intval($idadmin) > 0 && strlen($nomservice) > 0 && intval($validite) > 0 )
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $admin = $entityManager->getRepository(Admin::class)->find($idadmin);
            $service = (new Service())->setNomService( $nomservice )->setValidite($validite);
           
            $admin->setService( $service );

            $historiqueService = (new HistoriqueService())
                    ->setNomService($nomservice)->setValidite($validite)
                    ->setJour( date('d') )->setMois( date('m') )->setAnnee( date('Y') );
            $entityManager->persist($historiqueService);
            $service->addHistoriqueService( $historiqueService );
            $entityManager->persist($service);
            $entityManager->persist($admin);
            $entityManager->flush();
            $response = array("status"=>"ok");
        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
        
    }

    /**
     * @Rest\Get("/services/update/{id}/{libelle}/{validite}")
     */
    public function updateService($id,$libelle,$validite)
    {
        $response = array();
        if(  intval($id) > 0 && strlen($libelle) > 0 && intval($validite) > 0 )
        {
            $entityManager = $this->getDoctrine()->getManager();

            $service = $entityManager->getRepository(Service::class)
                        ->find($id)->setNomService($libelle);

            $historiqueService = (new HistoriqueService())->setNomService($libelle)
                ->setValidite($validite)->setJour( date('d') )
                ->setMois( date('m') )->setAnnee( date('Y') );
            $entityManager->persist($historiqueService);
            $service->addHistoriqueService( $historiqueService );
            $entityManager->persist($service);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
        
    }

    /**
     * @Rest\Get("/services/remove/{id}", requirements={"id": "\d+"})
     */
    public function removeService($id)
    {
        $response = array();
        if( intval($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $service = $entityManager->getRepository(Service::class)->find($id);
            $entityManager->remove($service);
            $entityManager->flush();
            $response = array("status"=>"ok");

        }else $response = array("status"=>"error");
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }


    /**
     * @Rest\Get("/services/{id}", requirements={"id": "\d+"})
     */
    public function findOneService($id)
    {
        $response = array();
        if( intval($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $service = $entityManager->getRepository(Service::class)->find($id);
            $response = ServicesRaffinage::removeCircular($service);
        }else $response = array("status"=>"error");
        
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/services")
     */
    public function service()
    {
        $allSvcs0 = $this->getDoctrine()->getRepository(Service::class)->findAll();
        $response = ServicesRaffinage::removeAllCircular($allSvcs0);
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view); 
    }

}
