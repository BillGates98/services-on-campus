<?php

namespace App\Raffinage;

use App\Entity\Service;
use App\Entity\Categories0;

class ServicesRaffinage
{
    

    public static function removeCircular(Service $svc)
    {
        $service = (new Service())->setNomService( $svc->getNomService() )
            ->setId( $svc->getId() )->setValidite( $svc->getValidite() );
         return $service;
    } 

    public static function removeAllCircular($services)
    {
        $allSvcs = array();
        foreach ($services as $key => $value) 
            $allSvcs[$key] = ServicesRaffinage::removeCircular($value) ;
        return $allSvcs;
    }

}
