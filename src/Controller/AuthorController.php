<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController
{

    /**
     * @Route("/author", name="app_author", methods={"HEAD", "GET"})
     */
    #[Route('/author', name: 'app_author', methods:["HEAD", "GET"])]
    public function index(AuthorRepository $authorRepository): JsonResponse
    {
        $authors = $authorRepository->findAll();

        return $this->json([
            'authors' => $authors
        ]);
    }

    #[Route('/author', name: 'app_author_new', methods:["POST"])]
    public function new(): JsonResponse
    {
        return $this->json([
            'message' => 'Author controller : NEW!',
        ]);
    }

    #[Route('/author/{id}', name: 'app_author_show', methods:["HEAD","GET"])]
    public function read(): JsonResponse
    {
        return $this->json([
            'message' => 'Author controller : READ!',
        ]);
    }

    #[Route('/author/{id}', name: 'app_author_edit', methods:["PATCH"])]
    public function update(): JsonResponse
    {
        return $this->json([
            'message' => 'Author controller : PATCH!',
        ]);
    }

    #[Route('/author/{id}', name: 'app_author_show', methods:["DELETE"])]
    public function delete($id): JsonResponse
    {
        return $this->json([
            'message' => 'Author controller : DELETE !'. $id,
        ]);
    }
}
