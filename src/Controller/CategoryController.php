<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", methods="GET")
     */
    public function index(
        CategoryRepository $repository,
        PostRepository $postRepository
    ): Response {
        $categories = $repository->findAll();
        $normalizedCategories = [];
        foreach ($categories as $category){
            $normalizedCategories[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'count' => $postRepository->count(['attachedTo' => $category]),
            ];
        }

        return $this->json($normalizedCategories);
    }
}
