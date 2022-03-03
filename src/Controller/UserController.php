<?php

// src/Controller/UserController.php
namespace App\Controller;

use App\Entity\User;
use App\Entity\UserException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * Add new user form
     * @Route("/", name="user_form")
     */
    public function userForm(): Response
    {
        return $this->render('user.html.twig');
    }

    /**
     * List all users
     * @Route("/users", name="show_users")
     */
    public function showUsers(ManagerRegistry $doctrine): JsonResponse
    {
        $repository = $doctrine->getRepository(User::class);
        $users = $repository
            ->createQueryBuilder('p')
            ->getQuery()
            ->getArrayResult();

        return new JsonResponse($users);
    }

    /**
     * List user by id
     * @Route("/users/{id}", name="show_user")
     */
    public function showUser(
        SerializerInterface $serializer,
        ManagerRegistry $doctrine,
        int $id): JsonResponse
    {
        $user = $doctrine->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(
                [
                    "code" => 404,
                    "error" => "user not found"
                ],404
            );
        }

        return new JsonResponse(
            json_decode($serializer->serialize($user, 'json'),true)
        );
    }
}