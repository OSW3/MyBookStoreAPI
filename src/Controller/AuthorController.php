<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AuthorController extends AbstractController
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }


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



        // Define the response array
        $response = [];



        // HEADER
        // --

        // Define the header of the response
        $response['header'] = [];

        // Time refereces
        $response['header']['datetime'] = date('Y-m-d H:i:s');
        $response['header']['timestamp'] = time();

        // Response code
        $response['header']['status'] = [];
        $response['header']['status']['code'] = Response::HTTP_OK;
        $response['header']['status']['text'] = Response::$statusTexts[Response::HTTP_OK];

        // Define the URI EndPoint
        $response['header']['endpoint'] = $request->getScheme()."://".$request->getHttpHost();



        // CONTENT
        // --
        
        // Define the content of the response
        $response['content'] = [];

        // Define the response subject
        $response['content']['authors'] = $authors;

        // Define pagination data
        $response['content']['pages'] = [];

        $response['content']['pages']['perPage'] = 20;
        $response['content']['pages']['current'] = 10;
        $response['content']['pages']['first'] = "/authors?page=1";
        $response['content']['pages']['prev'] = "/authors?page=9";
        $response['content']['pages']['next'] = "/authors?page=11";
        $response['content']['pages']['last'] = "/authors?page=42";


        return $this->json($response);
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
