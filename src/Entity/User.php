<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $postcode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Will only return instance of User if valid. Otherwise throw UserException
     * @param string $password
     * @throws UserException
     * @return self
     */
    public function validatePassword(string $password){

        if(!preg_match('/[a-z]/', $password)){
            throw new UserException(UserException::$errorLower);
        }

        if(!preg_match('/[A-Z]/', $password)){
            throw new UserException(UserException::$errorUpper);
        }

        if(!preg_match('/[0-9]/', $password)){
            throw new UserException(UserException::$errorDigit);
        }

        if(strlen($password) < 8 ){
            throw new UserException(UserException::$errorLength);
        }

        return $this;
    }

    /**
     * @param $email
     * @throws UserException
     * @return self
     */
    public function validateEmail($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new UserException(UserException::$email);
        }
        return $this;
    }

    /**
     * Set password never saves actual password only a hash which must be compared with password_verify
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = \password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }
}
