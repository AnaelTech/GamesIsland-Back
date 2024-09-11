<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;


#[AsController]
class meController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $token = $request->headers->get('BEARER');
        error_log('Token: ' . $token);

        $user = $this->getUser();

        if (!$user) {
            return new Response('User not authenticated', 401);
        }


        return $this->json($user, 201, [], ['groups' => 'user:read']);
    }
}
