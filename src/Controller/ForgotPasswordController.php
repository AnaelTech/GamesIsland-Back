<?php
// src/Controller/ForgotPasswordController.php

// src/Controller/ForgotPasswordController.php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Mime\Address;

class ForgotPasswordController extends AbstractController
{
    #[Route('/api/forgot-password', name: 'app_forgot_password', methods: ['POST'])]
    public function forgotPassword(
        Request $request,
        UserRepository $userRepository,
        MailerInterface $mailer,
        TokenGeneratorInterface $tokenGenerator
    ): Response {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];

        $user = $userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return $this->json(['message' => 'Email non trouvé'], Response::HTTP_NOT_FOUND);
        }

        // Générer un token de réinitialisation
        $resetToken = $tokenGenerator->generateToken();
        $user->setResetToken($resetToken);
        $userRepository->save($user);

        // Contenu HTML de l'e-mail
        $htmlContent = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 50px auto;
                    background: white;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    padding: 20px;
                }
                h2 {
                    color: #333;
                }
                a {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 10px 15px;
                    background-color: #132E35;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                }
                a:hover {
                    background-color: #2D4A53;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2>Réinitialisation de votre mot de passe</h2>
                <p>Bonjour,</p>
                <p>Vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le lien ci-dessous pour créer un nouveau mot de passe :</p>
                <a href="http://localhost:4200/reset-password?token=' . $resetToken . '">Réinitialiser le mot de passe</a>
                <p>Si vous n\'êtes pas à l\'origine de cette demande, vous pouvez ignorer cet e-mail.</p>
                <p>Cordialement,<br>L\'équipe GamesIsland</p>
            </div>
        </body>
        </html>';

        // Envoyer l'e-mail
        $emailMessage = (new Email())
            ->from(new Address('no-reply@gamesisland.com', 'Games Island Support'))  // Utiliser l'objet Address
            ->to($user->getEmail())
            ->subject('Réinitialisez votre mot de passe')
            ->html($htmlContent); // Utilisez html() au lieu de text()

        $mailer->send($emailMessage);

        return $this->json(['message' => 'E-mail envoyé'], Response::HTTP_OK);
    }
}
