<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class DemoController extends AbstractController
{
    public function index(): Response
    {
        return new Response('{"message": "Bonjour !"}', Response::HTTP_OK, [
            'Content-type' => 'application/json',
        ]);
    }

    public function index2(int $id, Request $request, TranslatorInterface $translator): Response
    {
        $option = $request->query->get('option', 'global.default_value'); // $_GET
        $requestBody = $request->getContent();
        $postData = $request->request->all(); // $_POST

        return $this->json([
            'id' => $id,
            'url' => $this->generateUrl('index2', ['id' => $id]),
            'option' => $translator->trans('global.default_value'),
            'trans_placeholders' => $translator->trans('mail.inbox.unread', ['%count%' => 12]),
        ]);
    }
}
