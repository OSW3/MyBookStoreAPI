<?php

namespace App\Controller;

use App\Context\ControllerContext;
use App\Repository\AuthorRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

class AuthorController extends ControllerContext
{
    #[Route('/authors', name: 'app_author', methods:["HEAD", "GET"])]
    public function index(SerializerInterface $serializer, AuthorRepository $authorRepository, Request $request): JsonResponse
    {
        $authors = $authorRepository->findAll();

        // -- Pseudo serialisation
        // -- 
        foreach ($authors as $author_key => $author)
        {
            $books = $author->getBooks();

            foreach ($books as $book_key => $book)
            {
                $books[$book_key] = [
                    'id' => $book->getId(),
                    'title' => $book->getTitle(),
                    'href' => $this->urlGenerator->generate('app_book_show', ['id' => $book->getId()]),

                ];
            }

            $authors[$author_key] = [
                'id' => $author->getId(),
                'firstname' => $author->getFirstname(),
                'lastname' => $author->getLastname(),
                'books' => $books,
                'href' => $this->urlGenerator->generate('app_author_show', ['id' => $author->getId()]),
            ];
        }
        // -- 
        // -- Fin Pseudo serialisation

        return $this->json($this->response($request, $authors, "authors"));
    }

    #[Route('/authors', name: 'app_author_new', methods:["POST"])]
    public function new(): JsonResponse
    {
        return $this->json([
            'message' => 'Author controller : NEW!',
        ]);
    }

    #[Route('/authors/{id}', name: 'app_author_show', methods:["HEAD","GET"])]
    public function read(): JsonResponse
    {
        // TP: Creer la reponse API de cette page

        return $this->json([
            'message' => 'Author controller : READ!',
        ]);
    }

    #[Route('/authors/{id}', name: 'app_author_edit', methods:["PATCH"])]
    public function update(): JsonResponse
    {
        return $this->json([
            'message' => 'Author controller : PATCH!',
        ]);
    }

    #[Route('/authors/{id}', name: 'app_author_show', methods:["DELETE"])]
    public function delete($id): JsonResponse
    {
        return $this->json([
            'message' => 'Author controller : DELETE !'. $id,
        ]);
    }
}
