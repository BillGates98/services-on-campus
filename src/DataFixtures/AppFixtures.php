<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\SuperAdmin;
use App\Entity\Admin;
use App\Entity\Service;
use App\Entity\Categories0;
use App\Entity\Produit;
use App\Entity\HistoriqueProduit;
use App\Entity\Client;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /*
        * generation des fausses donnees pour le client et ses numeros
        */
        for( $i = 0; $i < 10; $i ++)
        {

        }
         
        /*
        * generation des donnees dans la table des supers admins
        *
        */
        for($i = 0; $i < 20;$i++ )
        {
            $s_admin = (new SuperAdmin())->setLogin('Keyboard -> '.$i)
                ->setPassword(1999 + $i);
            $manager->persist($s_admin);
            $manager->flush();
        }


        $cats0 = [];
        /*
        * generation des donnees dans la table des admins
        */
        for($i = 0; $i < 20;$i++ )
        {
             $service = (new Service())->setNomService('service -> '.$i)
             ->setValidite(1 + $i);
             for($j = 0 ; $j < 5;$j++)
             {
                $categories0 = (new Categories0())->setLibelle(" categories0 -> ".($j*$i) );
                 $manager->persist($categories0);
                 $service->addCategories0( $categories0 );
                 $cats0[] = $categories0;
             }
             $manager->persist($service);

            $admin = (new Admin())->setLogin("Mr Bill ".$i)
            ->setPassword("Gates=:=".$i)
            ->setService($service);
            $manager->persist($admin);
            $manager->flush();
        }

        foreach ($cats0 as $key => $value) {
             /*
                    * generation des donnees dans la table des   produits
                    */
                    for($i = 0; $i < 5;$i++ )
                    {

                        $prod = (new Produit())->setNom('Produit -> '.($i*$j) )
                                            ->setPrix( (1999*($i*$j))%1000 )
                                            ->setImage( (( 1999*($i*$j) )%1000 ).'.jpeg')
                                            ->setCategories0( $value );
                        $manager->persist($prod);

                        // on pousse dans l'historique
                        $hprod = (new HistoriqueProduit())->setNom('Produit -> '.($i*$j) )
                                            ->setPrix( (1999*($i*$j))%1000 )
                                            ->setImage( (( 1999*($i*$j) )%1000 ).'.jpeg')
                                            ->setProduit( $prod )
                                            ->setJour( date('d') )->setMois( date('m') )
                                            ->setAnnee( date('Y') );
                        $manager->persist($hprod);
                        $manager->flush();
                    }

        }
    }
}
