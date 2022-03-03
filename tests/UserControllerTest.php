<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use App\Entity\UserException;

class UserControllerTest extends WebTestCase
{
    public function testNewUserForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'New User');
    }

    function testAddNewUser(): void{
        $client = static::createClient();
        $crawler = $client->request('PUT', '/user',[
            "email" => "test@email.com",
            "password" => "Password1!",
        ]);
        $this->assertResponseIsSuccessful();
    }

    public function testShowUsers(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users');

        $response = $client->getResponse();

        $v = json_decode($response->getContent(), true);
        
        $this->assertSame($v[0]["email"],"test@email.com");
        $this->assertSame($v[0]["password"],'$2y$10$wY/7.62CL0uvHdZzRD4GZeaDK74k37YYu3oxHJ/o8SVIGOcFl9qqu');

        $this->assertResponseIsSuccessful();
    }    

    function testAddUserInvalidEmail(): void{
        
        $client = static::createClient();
        $crawler = $client->request('PUT', '/user',[
            "email" => "test@email",
            "password" => "Password1!",
        ]);
        
        $response = $client->getResponse();

        $this->assertSame(422, $response->getStatusCode());
        $this->assertSame([
            "status" => "invalid input",
            "code" => 422,
            "error" => UserException::$email,
        ], json_decode($response->getContent(), true) );
    }
   
}
