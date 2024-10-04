<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class meController extends AbstractController
{
    public function __invoke(Request $request, NormalizerInterface $normalizer): Response
    {
        // Continuer avec l'authentification si le cookie est bien présent
        $user = $this->getUser();

        if (!$user) {
            return $this->json([
                'status' => 'error',
                'message' => 'User not authenticated',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $jsonLdData = $normalizer->normalize($user, 'jsonld', [
            'groups' => ['user:read'],
        ]);

        return $this->json($jsonLdData);
    }
}
