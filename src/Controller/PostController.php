<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class PostController extends AbstractController
{
    /**
     * @Route("/post", methods="GET")
     */
    public function index(PostRepository $repository): Response
    {
        $posts = $repository->findAll();

        return $this->json($posts, Response::HTTP_OK, [], [
            AbstractNormalizer::GROUPS => ['main'],
        ]);
    }

    /**
     * @Route("/post/{id}", requirements={"id": "\d+"}, methods="GET")
     */
    public function show(Post $post): Response
    {
        /*
         * Détecte la propriété private $title
         * Recherche sur les méthodes suivantes:
         *  - public function title()
         *  - public function getTitle()
         *  - public function hasTitle()
         *  - public function isTitle()
         */

        return $this->json($post, Response::HTTP_OK, [], [
            AbstractNormalizer::GROUPS => ['main', 'detail'],
        ]);
    }

    /**
     * @Route("/post", methods="POST")
     */
    public function new(
        Request $request,
        EntityManagerInterface $manager,
        SerializerInterface $serializer
    ): Response {
        $post = $serializer->deserialize($request->getContent(), Post::class, 'json');
        $post->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($post);
        $manager->flush();

        return $this->redirectToRoute('app_post_show', [
            'id' => $post->getId(),
        ], Response::HTTP_SEE_OTHER);
    }
}
