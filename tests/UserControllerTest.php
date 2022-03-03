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

        $this->assertResponseIsSuccessful();
    }
   
}
