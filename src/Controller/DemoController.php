<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DemoController
{
    public function index(): Response
    {
        return new Response('{"message": "Bonjour !"}', Response::HTTP_OK, [
            'Content-type' => 'application/json',
        ]);
    }

    public function index2(int $id): Response
    {
        return new JsonResponse(['id' => $id]);
    }
}
