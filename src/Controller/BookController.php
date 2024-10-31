<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/listBook', name: 'list_book')]
     public function listBooks(ManagerRegistry $doctrine): Response
     {  
         $bookRepo=$doctrine->getRepository(Book::class);
         $books = $bookRepo->findAll();

         return $this->render('book/listbook.html.twig', [
             'books'=> $books, 
         ]);
    }

    #[Route('/addBook', name: 'add_Book')]
    public function addBook(ManagerRegistry $doctrine , Request $request): Response
    {  
        $book= new Book(); //init Boook
        $book->setEnabled(true);
        $form=$this->createForm(BookType::class,$book); //creation form
        $form->add('Ajouter',SubmitType::class);
        
        $form->handleRequest($request);
        if($form->isSubmitted()){
            ////Persistence des données
            $em=$doctrine->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('list_book');
        }
        return $this->render('book/addBook.html.twig', [
            'BookForm'=> $form->createView(),
            
        ]);
    }

    #[Route('/deleteBook/{id}', name: 'DeleteBook')]
    public function deleteBook(ManagerRegistry $doctrine, $id): Response
    {  
        $bookRepo=$doctrine->getRepository(Book::class);
        $book=$bookRepo->find($id);
        $em=$doctrine->getManager();
        $em->remove($book);
        $em->flush();

        return $this->redirectToRoute('list_book');
    }

    #[Route('/editBook/{id}', name: 'edit_Book')]
    public function editBook(ManagerRegistry $doctrine , Request $request , $id): Response
    {  $bookRepo=$doctrine->getRepository(Book::class);
        $book=$bookRepo->find($id);
        $form=$this->createForm(BookType::class,$book); //creation form
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            ////Persistence des données
            $em=$doctrine->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('list_book');
        }
        return $this->render('book/editBook.html.twig', [
            'bookForm'=> $form->createView(),
            
        ]);

        

    }



}