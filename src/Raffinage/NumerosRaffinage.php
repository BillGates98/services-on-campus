<?php

namespace App\Raffinage;

use App\Entity\Numeros;

class NumerosRaffinage
{
    

    public static function removeCircular(Numeros $svc)
    {
         
        $Numeros = (new Numeros())->setOperateur( $svc->getOperateur() )
                            ->setNumero( $svc->getNumero() )
                            ->setId( $svc->getId() );
        return $Numeros;
    } 

    public static function removeAllCircular($allClis)
    {
        $allNumeross = array();
        foreach ($allClis as $key => $value) 
            $allNumeross[$key] = NumerosRaffinage::removeCircular($value) ;
        return $allNumeross;
    }

}
