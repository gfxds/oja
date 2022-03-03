<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;


use App\Entity\User;
use App\Entity\UserException;


class UserTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
    }

    public function testSetPassword(): void{
        $user = $this->user->setPassword("password");

        $hash = $user->getPassword();

        $verify = password_verify("password",$hash);

        $this->assertEquals(true, $verify);
    }


    public function testValidatePasswordUpper(): void
    {
        $this->expectException(UserException::class);

        $this->user->validatePassword("UPPERONLY");
    }

    public function testValidatePasswordLower(): void
    {
        $this->expectException(UserException::class);

        $this->user->validatePassword("loweronly");
    }

    public function testValidatePasswordTextOnly(): void
    {
        $this->expectException(UserException::class);

        $this->user->validatePassword("TeXtOnly");
    }

    public function testValidatePasswordShort(): void
    {
        $this->expectException(UserException::class);

        $this->user->validatePassword("Sh0rt!");
    }

    public function testValidatePasswordValid(): void
    {
        $user = $this->user->validatePassword("Password1!");

        $this->assertInstanceOf(User::class, $user);
    }
}