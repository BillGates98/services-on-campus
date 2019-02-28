<?php

namespace App\Raffinage;

use App\Entity\HistoriqueService;
use App\Entity\Service;

class HistoriqueServiceRaffinage
{
    

    public static function removeCircular(HistoriqueService $hsvc)
    {
         
        $hservice = new HistoriqueService();
        $hservice->setNomService( $hsvc->getNomService() )
            ->setId( $hsvc->getId() )
            ->setJour( $hsvc->getJour() )
            ->setMois( $hsvc->getMois() ) 
            ->setAnnee( $hsvc->getAnnee() ) 
            ->setValidite( $hsvc->getValidite() ); 
         return $hservice;
    } 

    public static function removeAllCircular($hservices)
    {
        $allHsvcs = array();
        foreach ($hservices as $key => $value) 
            $allHsvcs[$key] = HistoriqueServiceRaffinage::removeCircular($value);
        return $allHsvcs;
    }

}
