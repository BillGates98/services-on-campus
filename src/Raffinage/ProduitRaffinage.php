<?php

namespace App\Raffinage;

use App\Entity\Produit;
use App\Entity\Categories0;

class ProduitRaffinage
{
    

    public static function removeCircular(Produit $prd)
    {
        $produit = new Produit();
        $produit->setNom( $prd->getNom() )
            ->setId( $prd->getId() )
            ->setPrix( $prd->getPrix() )
            ->setImage( $prd->getImage() );
         return $produit;
    } 

    public static function removeAllCircular($produits)
    {
        $allProds = array();
        foreach ($produits as $key => $value) 
            $allProds[$key] = ProduitRaffinage::removeCircular($value) ;
        return $allProds;
    }

}
