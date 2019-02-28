<?php

namespace App\Raffinage;

use App\Entity\Service;
use App\Entity\Categories0;

class Categories0Raffinage
{
    

    public static function removeCircular(Categories0 $cat0)
    {
        $service = new Service();
         $service->setNomService( $cat0->getService()->getNomService() );
         $service->setId( $cat0->getService()->getId() );
         $service->setValidite( $cat0->getService()->getValidite() );
         return $service;
    } 

    public static function removeAllCircular($cats0)
    {
        $allCats0 = array();
        foreach ($cats0 as $key => $value) 
            $allCats0[$key] = $value->setService( Categories0Raffinage::removeCircular($value) );
        
        return $allCats0;
    }

}
