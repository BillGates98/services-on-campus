<?php

namespace App\Raffinage;

use App\Entity\TicketValide;
use Skies\QRcodeBundle\Generator\Generator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class TicketValideRaffinage
{
    

    public static function removeCircular(TicketValide $svc)
    {
         
        $TicketValide = (new TicketValide())->setCode( $svc->getCode() )
                            ->setJour( $svc->getJour() )
                            ->setMois( $svc->getMois() )
                            ->setAnnee( $svc->getAnnee() ) 
                            ->setId( $svc->getId());
        return $TicketValide;
    } 

    public static function removeAllCircular($allClis)
    {
        $allTicketValides = array();
        foreach ($allClis as $key => $value) 
            $allTicketValides[$key] = TicketValideRaffinage::removeCircular($value) ;
        return $allTicketValides;
    }

    private function generateTicket()
    {
        $code = uniqid('',TRUE);
        $code = md5($code,FALSE);
        $options = array(
            'code'   => $code,
            'type'   => 'qrcode',
            'format' => 'png',
            'width'  => 20,
            'height' => 20,
            'color'  => array(  0,0,0  ),
        );
        $generator = new Generator();
        $barcode = $generator->generate($options);
        $savePath = './tickets/';
        $fileName = $code.'.png';
        file_put_contents($savePath.$fileName, base64_decode($barcode));
        return $code;
    }


    // faire le paiement Momo
    public static function makePaiement($numero,$montant)
    {
        $operateur = TicketValideRaffinage::checkNumber($numero);
        if( $operateur == "Momo" )
        {

          try {
            $client = new Client();
            $res = $client->request('GET','https://developer.mtn.cm/OnlineMomoWeb/faces/transaction/transactionRequest.xhtml?idbouton
            =2&typebouton=PAIE&_amount='.$montant.'&_tel='.$numero.'&_clP=&_email=billhappi@gmail.com&submit.x=104&submit.y=70', [
            'headers' => [
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
            ]]);
            $result = json_decode( "".$res->getBody()->getContents() );
            if( $result->OpComment === "Transaction completed DEBIT and CREDIT" )
            {
                return $this->generateTicket();
            }

        }catch( RequestException $e )
        {
            return $e;
        }

         }else if( $operateur === "Orange" )
         {
            return "";
         }

        return "";
    }


    public static function checkNumber($numero)
    {
        $num = strlen( trim($numero) );
        if ( $num > 0 && ( preg_match( "#^65[01234]{1}\d{6}$#i", $numero) || preg_match( "#^6[78]\d{7}$#i", $numero) ) ) return "Momo";
        elseif( $num > 0 && ( preg_match( "#^65[56789]{1}\d{6}#i", $numero) || preg_match( "#^69\d{7}$#i", $numero) ) ) return "Orange";
        return "";
    }
}
