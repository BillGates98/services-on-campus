<?php

namespace App\Raffinage;

use App\Entity\Client;

class ClientRaffinage
{
    

    public static function removeCircular(Client $svc)
    {
         
        $client = (new Client())->setMatricule( $svc->getMatricule() )
                            ->setId( $svc->getId() );
        return $client;
    } 

    public static function removeAllCircular($allClis)
    {
        $allClients = array();
        foreach ($allClis as $key => $value) 
            $allClients[$key] = ClientRaffinage::removeCircular($value) ;
        return $allClients;
    }

    public static function checkMatricule($matricule)
    {
        $matr = trim($matricule );
        if ( strlen($matr) > 0 && preg_match( "#CM-UDS-\d{2,}[A-Z]{3}\d{1,}#i", $matr) ) return true;
        return false;
    }

}
