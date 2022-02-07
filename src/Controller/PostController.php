<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post", methods="GET")
     */
    public function index(PostRepository $repository): Response
    {
        $posts = $repository->findAll();

        $normalizedPosts = array_map(function (Post $post) {
            return [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'created_at' => $post->getCreatedAt()->format('c'),
            ];
        }, $posts);

        return $this->json($normalizedPosts);
    }

    /**
     * @Route("/post/{id}", requirements={"id": "\d+"}, methods="GET")
     */
    public function show(Post $post): Response
    {
        return $this->json([
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'created_at' => $post->getCreatedAt()->format('c'),
            'body' => $post->getBody(),
        ]);
    }
}
