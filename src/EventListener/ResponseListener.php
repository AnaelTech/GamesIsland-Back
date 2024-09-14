<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListener
{
    public function onKernelResponse(ResponseEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        if ($request->isMethod('OPTIONS')) {
            // Optionnel : configure une réponse vide pour les requêtes OPTIONS
            $response = $event->getResponse() ?: new Response();
            $response->setContent('');
            $event->setResponse($response);
        }

        $response = $event->getResponse();
        $response->headers->set("Access-Control-Allow-Credentials", "true");
        // $response->headers->set("Access-Control-Allow-Origin", "http://localhost:4200");
        $response->headers->set("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
        $response->headers->set("Access-Control-Allow-Headers", "Content-Type, Authorization");
    }
}
