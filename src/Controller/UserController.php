<?php

namespace App\Controller;

use App\Context\ControllerContext;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends ControllerContext
{
    #[Route('/users', name: 'app_user')]
    public function index(Request $request, UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();

        foreach ($users as $user_key => $user)
        {
            $users[$user_key] = [
                'id' => $user->getId(),
                'firstname' => $user->getFirstname(),
                'lastname' => $user->getLastname(),
                'roles' => $user->getRoles(),
                'email' => $user->getEmail(),
            ];
        }

        return $this->json($this->response($request, $users, "users"));
    }
}
