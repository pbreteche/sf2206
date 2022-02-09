<?php

namespace App\Controller;

use App\Transient\FacebookPublicationInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/social")
 */
class SocialController extends AbstractController
{
    /**
     * @Route("/facebook/publish", methods="POST")
     */
    public function publishOnFacebook(Request $request, SerializerInterface $serializer): Response
    {
        $data = $serializer->deserialize($request->getContent(), FacebookPublicationInput::class, 'json');

        return $this->json([]);
    }
}