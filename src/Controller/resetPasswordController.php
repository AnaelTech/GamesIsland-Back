<?php
// src/Controller/ResetPasswordController.php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; // Utilisez la nouvelle interface

class resetPasswordController extends AbstractController
{
    #[Route('/api/reset-password', name: 'app_reset_password', methods: ['POST'])]
    public function resetPassword(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher // Utilisez le nouveau UserPasswordHasherInterface
    ): Response {
        $data = json_decode($request->getContent(), true);
        $token = $data['token'] ?? null;
        $newPassword = $data['newPassword'] ?? null;

        // Vérifier si les données nécessaires sont présentes
        if (!$token || !$newPassword) {
            return $this->json(['message' => 'Token ou nouveau mot de passe manquant'], Response::HTTP_BAD_REQUEST);
        }

        $user = $userRepository->findOneBy(['resetToken' => $token]);

        if (!$user) {
            return $this->json(['message' => 'Token invalide'], Response::HTTP_BAD_REQUEST);
        }

        // Réinitialiser le mot de passe
        $encodedPassword = $passwordHasher->hashPassword($user, $newPassword); // Utilisez hashPassword
        $user->setPassword($encodedPassword);
        $user->setResetToken(null); // Supprimer le token après réinitialisation

        $userRepository->save($user, true);

        return $this->json(['message' => 'Mot de passe réinitialisé'], Response::HTTP_OK);
    }
}
