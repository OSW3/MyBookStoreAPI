<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author", name="app_author", methods={"HEAD", "GET"})
     */
    #[Route('/author', name: 'app_author', methods:["HEAD", "GET"])]
    public function index(SerializerInterface $serializer, AuthorRepository $authorRepository): JsonResponse
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
                ];
            }

            $authors[$author_key] = [
                'id' => $author->getId(),
                'firstname' => $author->getFirstname(),
                'lastname' => $author->getLastname(),
                'books' => $books,
            ];
        }
        // -- 
        // -- Fin Pseudo serialisation
        
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
