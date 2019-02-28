<?php

namespace App\Controller\Rest;

use App\Entity\Produit;
use App\Raffinage\ProduitRaffinage;
use App\Entity\Categories0;
use App\Repository\ProduitRepository;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\View(serializerGroups={"produits"})
 */
class ProduitController extends FOSRestController
{

    /**
     * @var ProduitRepository
     */
    private $rp;

    public function __construct(ProduitRepository $sar)
    {
       $this->rp = $sar;
    }

    /**
     * @Rest\Get("/produits/remove/{id}", requirements={"id": "\d+"})
     */
    public function removeProduit($id)
    {
        $response = array();
        if( intval($id) > 0 ) 
        {   
            $entityManager = $this->getDoctrine()->getManager();
            $produit = $entityManager->getRepository(Produit::class)->find($id);
            $entityManager->remove($produit);
            $entityManager->flush();
            $response = array("status"=>"ok");
        }else $response = array("status"=>"error");

        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }


    /**
     * @Rest\Get("/produits/{id}", requirements={"id": "\d+"})
     */
    public function findOneProduit($id)
    {
        $response = array();
        if( intval($id) > 0 )
        {
            $entityManager = $this->getDoctrine()->getManager();
            $produit = $entityManager->getRepository(Produit::class)->find($id);
            $response = ProduitRaffinage::removeCircular($produit);
        }else $response = array("status"=>"error");
        
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/produits")
     */
    public function allProduits()
    {
        $allProduits = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        $response = ProduitRaffinage::removeAllCircular($allProduits);
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view); 
    }

    /**
     * @Rest\Get("categories0/{id}/produits")
     */
    public function allProduitsOfCat($id)
    {
        $allProduits = $this->getDoctrine()->getRepository(Produit::class)->findProductsOfCatById($id);
        $response = ProduitRaffinage::removeAllCircular($allProduits);
        $view = $this->view($response, Response::HTTP_OK);
        return $this->handleView($view); 
    }

}
