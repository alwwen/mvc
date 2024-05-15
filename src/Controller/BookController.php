<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/book/create', name: 'book_create')]
    public function createBook(
        ManagerRegistry $doctrine
    ): Response 
    {
        $entityManager = $doctrine->getManager();

        $book = new Book();
        $book->setTitle("Divergent");
        $book->setIsbn(9789174994711);
        $book->setAuthor("Veronica Roth");
        $book->setImage('divergent.webp');

        // tell Doctrine you want to (eventually) save the Book
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new book with id '.$book->getId());
    }

    #[Route('/library', name: 'book_show_all')]
    public function showAllBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('book/view.html.twig', $data);
    }

    #[Route('/book/delete/{id}', name: 'book_delete_by_id', methods: ['POST'])]
    public function deleteBookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_show_all');
    }

    #[Route('/book/show/{id}', name: 'book_by_id')]
    public function showProductById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        $data = [
            'book' => $book
        ];

        return $this->render('book/viewSingle.html.twig', $data);
    }

    #[Route('/book/edit/{id}', name: 'book_edit', methods: ['GET', 'POST'])]
    public function editBook(
        ManagerRegistry $doctrine,
        Request $request,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        if ($request->isMethod('POST')) {
            $book->setTitle($request->request->get('title'));
            $book->setAuthor($request->request->get('author'));
            $book->setIsbn($request->request->get('isbn'));

            $entityManager->flush();

            return $this->redirectToRoute('book_by_id', ['id' => $id]);
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/book/new', name: 'book_new', methods: ['GET', 'POST'])]
    public function newBook(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        if ($request->isMethod('POST')) {
            $entityManager = $doctrine->getManager();

            $book = new Book();
            $book->setTitle($request->request->get('title'));
            $book->setAuthor($request->request->get('author'));
            $book->setIsbn($request->request->get('isbn'));
            $book->setImage("placeholder_book.jpg");

            // tell Doctrine you want to (eventually) save the Book
            // (no queries yet)
            $entityManager->persist($book);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return $this->redirectToRoute('book_by_id', ['id' => $book->getId()]);
        }

        return $this->render('book/new.html.twig');
    }
}
