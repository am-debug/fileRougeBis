<?php

namespace App\DataFixtures;
use App\Entity\Profils;
use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


use Faker;



class AppFixtures extends Fixture
{
    private $password;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->password = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        // $product = new Product();
        // $manager->persist($product);
        // $use


        $manager->flush();
    }
}