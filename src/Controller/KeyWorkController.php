<?php

namespace App\Controller;

use App\Entity\KeyWord;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class KeyWorkController extends AbstractController
{
    /**
     * @Route("/keyword", methods="POST")
     */
    public function new(
        Request $request,
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): Response {
        $keyword = $serializer->deserialize($request->getContent(), KeyWord::class, 'json');
        $errors = $validator->validate($keyword);

        if (0 < $errors->count()) {
            return $this->json($errors, Response::HTTP_PRECONDITION_FAILED);
        }

        $manager->persist($keyword);
        $manager->flush($keyword);

        return $this->json([
            'status' => 'created',
            'id' => $keyword->getId(),
        ], Response::HTTP_CREATED);
    }
}