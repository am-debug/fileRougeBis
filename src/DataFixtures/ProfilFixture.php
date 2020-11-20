<?php

namespace App\DataFixtures;

use App\Entity\Profils;
use App\Entity\User;
use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilFixture extends Fixture 
{
public $tab=['ADMIN','Apprenant','Formateur','Cm'];
    public const REF ='ref';

    public function load(ObjectManager $manager)
    {
        for ($p=0;$p<4;$p++){
            $profil= new Profils();
            $profil->setLibelle($this->tab[$p]);
            $this->addReference(self::REF.$p,$profil);
            $manager->persist($profil);
        }
        $manager->flush();
    }
}