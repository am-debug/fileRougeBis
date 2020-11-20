<?php

namespace App\DataFixtures;

use App\Entity\Apprenant;
use App\Entity\Cm;
use App\Entity\Formateur;
use App\Entity\Admin;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder= $encoder;

    }
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('en_EN');
        $tab=[Admin::class,Apprenant::class,Formateur::class,CM::class];

        for ($p=0;$p<4;$p++) {
            $user = new  $tab[$p];
            $user->setPrenom($faker->firstName)
                ->setNom($faker->LastName)
                ->setEmail($faker->email)
                ->setPassword($this->encoder->encodePassword($user, 'passer'))
                ->setUsername($faker->Username)
                ->setTel(774347566)
                ->setProfil($this->getReference(ProfilFixture::REF.$p));
            $manager->persist($user);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return array(
            ProfilFixture::class
        );
    }

}
