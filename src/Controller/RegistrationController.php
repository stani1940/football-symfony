<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        JWTTokenManagerInterface $JWTManager
    ): JsonResponse
    {
        // Get data from FormData (for file upload support)
        $name = $request->request->get('name');
        $username = $request->request->get('username');
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        
        // Validate required fields
        if (!$name || !$username || !$email || !$password) {
            return $this->json([
                'error' => 'Missing required fields: ' . json_encode([
                    'name' => $name ? 'ok' : 'missing',
                    'username' => $username ? 'ok' : 'missing',
                    'email' => $email ? 'ok' : 'missing',
                    'password' => $password ? 'ok' : 'missing',
                ])
            ], Response::HTTP_BAD_REQUEST);
        }

        // Check if user already exists
        $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            return $this->json([
                'error' => 'User with this email already exists'
            ], Response::HTTP_CONFLICT);
        }

        $existingUsername = $entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
        if ($existingUsername) {
            return $this->json([
                'error' => 'Username already taken'
            ], Response::HTTP_CONFLICT);
        }

        // Create new user
        $user = new User();
        $user->setName($name);
        $user->setUsername($username);
        $user->setEmail($email);
        
        // Hash password
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        
        // Set default values
        $user->setRoleId(2);
        $user->setActive(true);
        $user->setAdmin(false);
        $user->setStaff(false);
        
        // Handle avatar upload if present
        $avatarFile = $request->files->get('avatar');
        if ($avatarFile) {
            $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = time() . '_' . $avatarFile->getClientOriginalName();
            
            try {
                $avatarFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/avatars',
                    $newFilename
                );
                $user->setAvatar($newFilename);
            } catch (FileException $e) {
                return $this->json([
                    'error' => 'Failed to upload avatar: ' . $e->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        // Validate user entity
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json([
                'errors' => $errorMessages
            ], Response::HTTP_BAD_REQUEST);
        }

        // Persist user
        $entityManager->persist($user);
        $entityManager->flush();

        // Generate JWT token
        $token = $JWTManager->create($user);

        return $this->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'avatar' => $user->getAvatar(),
                'roleId' => $user->getRoleId(),
            ]
        ], Response::HTTP_CREATED);
    }
}
