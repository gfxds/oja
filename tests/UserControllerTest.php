<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testNewUserForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'New User');
    }

    public function testShowUsers(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users');
<<<<<<< HEAD
        $this->assertResponseIsSuccessful();
    }

    function testAddNewUser(): void{
        $client = static::createClient();
        $crawler = $client->request('PUT', '/user',[
            "email" => "test@email.com",
            "password" => "Password1!",
        ]);
=======

>>>>>>> 5fb0c9eb553ede8920e7436c4e4f666813559123
        $this->assertResponseIsSuccessful();
    }
   
}
