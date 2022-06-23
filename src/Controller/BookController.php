<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book', methods:["HEAD", "GET"])]
    public function index(BookRepository $bookRepository): JsonResponse
    {
        $books = $bookRepository->findAll();
        
        return $this->json([
            'books' => $books
        ]);
    }
}
