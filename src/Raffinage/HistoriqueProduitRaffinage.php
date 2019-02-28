<?php

namespace App\Raffinage;

use App\Entity\HistoriqueProduit;
use App\Entity\Produit;

class HistoriqueProduitRaffinage
{
    public static function removeCircular(HistoriqueProduit $hsvc)
    {
         
        $hProduit = new HistoriqueProduit();
        $hProduit->setNom( $hsvc->getNom() )
            ->setPrix( $hsvc->getPrix() )
            ->setImage( $hsvc->getImage() )
            ->setId( $hsvc->getId() )
            ->setJour( $hsvc->getJour() )
            ->setMois( $hsvc->getMois() ) 
            ->setAnnee( $hsvc->getAnnee() ); 
         return $hProduit;
    } 

    public static function removeAllCircular($hProduits)
    {
        $allHsvcs = array();
        foreach ($hProduits as $key => $value) 
            $allHsvcs[$key] = HistoriqueProduitRaffinage::removeCircular($value);
        return $allHsvcs;
    }

}
