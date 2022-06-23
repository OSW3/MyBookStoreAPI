<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    #[Route('/books', name: 'app_book', methods:["HEAD", "GET"])]
    public function index(BookRepository $bookRepository): JsonResponse
    {
        $books = $bookRepository->findAll();
        
        return $this->json([
            'books' => $books
        ]);
    }

    #[Route('/books/{id}', name: 'app_book_show', methods:["HEAD", "GET"])]
    public function read(Book $book): JsonResponse
    {        
        return $this->json([
            'books' => $book
        ]);
    }
}
