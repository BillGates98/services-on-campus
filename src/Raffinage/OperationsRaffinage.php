<?php

namespace App\Raffinage;

use App\Entity\Operations;
use App\Entity\Produit;

class OperationsRaffinage
{
    

    public static function removeCircular(Operations $opts)
    {
        $operation = (new Operations())->setQuantite( $opts->getQuantite() )->setMontant( $opts->getMontant() )
        ->setJour( $opts->getJour() )->setMois( $opts->getMois() )->setAnnee( $opts->getAnnee() )->setHeure( $opts->getHeure() )
        ->setMinute( $opts->getMinute());

        $produit = (new Produit())->setNom( $opts->getProduit()->getNom() )->setId( $opts->getProduit()->getId() );

        $operation->setProduit( $produit );
;
         return $operation;
    } 

    public static function removeAllCircular($operations)
    {
        $allOps = array();
        foreach ($operations as $key => $value) 
            $allOps[$key] = OperationsRaffinage::removeCircular($value) ;
        return $allOps;
    }

}
