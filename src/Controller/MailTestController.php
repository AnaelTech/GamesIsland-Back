<?php
// src/Controller/MailTestController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailTestController extends AbstractController
{
    #[Route('/test-email', name: 'test_email')]
    public function testEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('anaelpayetpro@gmail.com')
            ->to('payet.anael97490@gmail.com') // Remplacez par une adresse e-mail valide
            ->subject('Test Email')
            ->text('This is a test email.');

        $mailer->send($email);

        return new Response('Email sent successfully!');
    }
}
