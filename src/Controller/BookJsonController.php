<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;

class BookJsonController extends AbstractController
{
    #[Route('/api/library/books', name: 'apiBook')]
    public function apiBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        $jsonArray = [];
        foreach($books as $book) {
            array_push($jsonArray, [
                'title' => $book->getTitle(),
                'isbn' => $book->getIsbn(),
                'author' => $book->getAuthor(),
                'image' => $book->getImage()
            ]);
        }
        $response = new JsonResponse($jsonArray);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route('/api/library/book/{isbn}', name: 'apiBookByIsbn', methods: ['GET', 'POST'])]
    public function apiBookByIsbn(
        BookRepository $bookRepository,
        string $isbn,
        Request $request
    ): Response {
        $book = $bookRepository->findOneBy(['isbn' => $isbn]);
        if (!$book) {
            return new JsonResponse([
                'error' => 'Book not found',
                'isbn' => $isbn,
            ]);
        }
        $jsonArray = [
            'title' => $book->getTitle(),
            'isbn' => $book->getIsbn(),
            'author' => $book->getAuthor(),
            'image' => $book->getImage()
        ];
        $response = new JsonResponse($jsonArray);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
