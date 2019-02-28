<?php

namespace App\Raffinage;

use App\Entity\Admin;
use App\Entity\Service;

class AdminRaffinage
{
    

    public static function removeCircular(Admin $admin)
    {
        $service = new Service();
         $service->setNomService( $admin->getService()->getNomService() );
         $service->setId( $admin->getService()->getId() );
         $service->setValidite( $admin->getService()->getValidite() );
         return $service;
    } 

    public static function removeAllCircular($admins)
    {
        $allAdms = array();
        foreach ($admins as $key => $value)
            $allAdms[$i] = $value->setService( AdminRaffinage::removeCircular($value) );

        return $allAdms;
    }

}
