<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoController extends AbstractController
{
    public function index(): Response
    {
        return new Response('{"message": "Bonjour !"}', Response::HTTP_OK, [
            'Content-type' => 'application/json',
        ]);
    }

    public function index2(int $id, Request $request): Response
    {
        $option = $request->query->get('option', 'valeur par défaut'); // $_GET
        $requestBody = $request->getContent();
        $postData = $request->request->all(); // $_POST

        dump($postData);

        return $this->json([
            'id' => $id,
            'url' => $this->generateUrl('index2', ['id' => $id]),
            'option' => $option,
        ]);
    }
}
