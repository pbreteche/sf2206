<?php

namespace App\Controller;

use App\Entity\KeyWord;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostController extends AbstractController
{
    private const POST_PER_PAGE = 5;

    /**
     * @Route("/post", methods="GET")
     */
    public function index(
        Request $request,
        PostRepository $repository,
        ValidatorInterface $validator
    ): Response {
        $page = $request->query->get('page', 1);

        $errors = $validator->validate($page, [
            new Regex('/^[1-9]\d*$/', 'page should be only digits starting with "1 - 9"'),
        ]);

        if (0 < $errors->count()) {
            return $this->json($errors, Response::HTTP_PRECONDITION_FAILED);
        }

        $posts = $repository->findLatestPublishedDQL(self::POST_PER_PAGE, ($page - 1) * self::POST_PER_PAGE);

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
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): Response {
        $post = $serializer->deserialize($request->getContent(), Post::class, 'json');
        $post->setCreatedAt(new \DateTimeImmutable());

        $errors = $validator->validate($post, null, ['create', 'Default']);

        if (0 < $errors->count()) {
            return $this->json($errors, Response::HTTP_PRECONDITION_FAILED);
        }

        $manager->persist($post);
        $manager->flush();

        return $this->redirectToRoute('app_post_show', [
            'id' => $post->getId(),
        ], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/post/{id}", requirements={"id": "\d+"}, methods="PUT")
     */
    public function update(
        Post $post,
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $manager,
        ValidatorInterface $validator
    ): Response {
        $serializer->deserialize($request->getContent(), Post::class, 'json', [
            AbstractNormalizer::OBJECT_TO_POPULATE => $post,
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['createdAt'],
        ]);

        $errors = $validator->validate($post);

        if (0 < $errors->count()) {
            return $this->json($errors, Response::HTTP_PRECONDITION_FAILED);
        }

        $manager->flush($post);

        return $this->redirectToRoute('app_post_show', [
            'id' => $post->getId(),
        ], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/post/with-keyword/{id}", requirements={"id": "\d+"}, methods="GET")
     */
    public function withKeyWord(KeyWord $keyWord, PostRepository $postRepository): Response
    {
        $posts = $postRepository->findHavingKeyword($keyWord);

        return $this->json($posts, Response::HTTP_OK, [], [
            AbstractNormalizer::GROUPS => ['main'],
        ]);
    }
}
