<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
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

        if (!$this->isGranted("ROLE_ADMIN")) {
            throw $this->createAccessDeniedException();
        }

        $this->denyAccessUnlessGranted("ROLE_ADMIN");

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

}