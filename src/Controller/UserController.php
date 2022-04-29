<?php

namespace App\Controller;

use App\Entity\UserType;
use App\Service\UserService;
use http\Exception\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to the UserController',
            'path' => 'src/Controller/UserController.php',
        ]);
    }


    #[Route('/create-user', name: 'app_user_create')]
    public function create(Request $request): Response
    {
        /** @var UserType||null $type */
        $type = ($request->getContent())['type'] ?? null;

        if ($type === null) {
            throw new InvalidArgumentException('Type is mandatory to be specified');
        }

        $user = $this->userService->createUser($type);

        $userType = $type->getType();
        $userName = $user->getName();
        $responseString = $userType.'has been created for'.$userName;

        return new Response($responseString);
    }
}
