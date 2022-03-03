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
     * Add new user
     * @Route("/user", name="add_new_user", methods={"POST","PUT"})
     */
    public function addNewUser(
        ManagerRegistry $doctrine,
        ValidatorInterface $validator,
        Request $request): JsonResponse
    {
        $user = new User();
        $password = $request->get('password');
        $email = $request->get('email');

        try{
            $user->validatePassword($password);
            $user->validateEmail($email);
        }catch (UserException $e){
            return new JsonResponse([
                "status" => "invalid input",
                "code" => 422,
                "error" => $e->getMessage(),
            ],422);
        }

        $user->setPassword($password);
        $user->setEmail($email);
        $user->setName($request->get('name'));
        $user->setPostcode($request->get('postcode'));

        //validate entity check for not null, type and other basic constraints
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new JsonResponse([
                "status" => "error",
                "code" => 400,
                "error" => "One or more inputs are invalid",
            ],400);
        }

        $entityManager = $doctrine->getManager();

        $entityManager->persist($user);

        $entityManager->flush();

        return new JsonResponse([
            "status" => "A new user has been added",
            "code" => 200,
        ]);
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