<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/api/user', name: 'api_user', methods: ['GET'])]
    public function getCurrentUser(): JsonResponse
    {
        $user = $this->getUser();
        
        if (!$user) {
            return $this->json([
                'error' => 'Not authenticated'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'user' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'avatar' => $user->getAvatar(),
                'roleId' => $user->getRoleId(),
                'active' => $user->isActive(),
                'admin' => $user->isAdmin(),
                'staff' => $user->isStaff(),
            ]
        ]);
    }

    #[Route('/api/logout', name: 'api_logout', methods: ['POST'])]
    public function logout(): JsonResponse
    {
        // With JWT, logout is handled on the client side by removing the token
        // This endpoint is just for consistency with traditional auth systems
        return $this->json([
            'message' => 'Logout successful. Please remove the token from client storage.'
        ]);
    }
}
