<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setName("username");
        $user->setEmail("email@email.com");
        $user->setPassword("Password1!");
        $user->setPostcode("SE1");

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
