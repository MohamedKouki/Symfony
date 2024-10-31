<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {   $age=25+25;
        return $this->render('author/index.html.twig', [
            'controller_name' => 'Mohamed',
            'age'=>$age
        ]);
    }

    // #[Route('/showauthor/{id}', name: 'showAuth')]
    // public function showAuthor($id): Response
    // {  $authors = array(
    //         array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
    //         'victor.hugo@gmail.com ', 'nb_books' => 100),
    //         array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
    //         ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
    //         array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
    //         'taha.hussein@gmail.com', 'nb_books' => 300),
    //     );


    //     $author = null;
    // for ($i=0; $i <count($authors) ; $i++) { 
    //     if($authors[$i]['id']== $id){
    //         $author= $authors[$i];
            
    //     }
    // }
    //     return $this->render('author/showAuthor.html.twig', [
    //         'author'=> $author
            
    //     ]);
    // }
// attelier 3
//       #[Route('/listauthor', name: 'listAuthor')]
//     public function listAuthors(): Response
//     {  
//         //  $authors=''; // No author Found !!
//         $authors = array(
//         array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
//         'victor.hugo@gmail.com ', 'nb_books' => 100),
//         array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
//         ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
//         array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
//         'taha.hussein@gmail.com', 'nb_books' => 300),
// );
//         return $this->render('author/listauthors.html.twig', [
//             'authors'=> $authors,
//         ]);
//     }
//atelier4
    // #[Route('/listauthor', name: 'listAuthor')]
    // public function listAuthors(ManagerRegistry $doctrine, Request $request): Response
    // {  
    //     $authorRepo=$doctrine->getRepository(Author::class);
    //     $authors = $authorRepo->findAll();
    //     $author= new Author(); //init Author
    //     $form=$this->createForm(AuthorType::class,$author); //creation form
    //     $form->add('Ajouter',SubmitType::class);
    //     $form->handleRequest($request);
    //     if($form->isSubmitted()){
    //         ////Persistence des données
    //         $em=$doctrine->getManager();
    //         $em->persist($author);
    //         $em->flush();
    //         return $this->redirectToRoute('listAuthor');
    //     }

    //     return $this->render('author/listauthors.html.twig', [
    //         'authors'=> $authors, 
    //         'authorForm'=> $form->createView(),
    //     ]);
    // }

    #[Route('/showauthor/{id}', name: 'showAuth')]
    public function showAuthor(ManagerRegistry $doctrine, $id): Response
    {  
        $authorRepo=$doctrine->getRepository(Author::class);
        $author=$authorRepo->find($id);

        return $this->render('author/showAuthor.html.twig', [
            'author'=> $author, 
            
        ]);
    }

    #[Route('/deleteAuthor/{id}', name: 'DeleteAuth')]
    public function deleteAuthor(ManagerRegistry $doctrine, $id): Response
    {  
        $authorRepo=$doctrine->getRepository(Author::class);
        $author=$authorRepo->find($id);
        $em=$doctrine->getManager();
        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('listAuthor');
    }

    #[Route('/addAuthor', name: 'add_Author')]
    public function addAuthor(ManagerRegistry $doctrine , Request $request): Response
    {  
        $author= new Author(); //init Author
        $form=$this->createForm(AuthorType::class,$author); //creation form
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            ////Persistence des données
            $em=$doctrine->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('listAuthor');
        }
        return $this->render('author/addAuthor.html.twig', [
            'authorForm'=> $form->createView(),
            
        ]);

        

    }
    #[Route('/editAuthor/{id}', name: 'edit_Author')]
    public function editAuthor(ManagerRegistry $doctrine , Request $request , $id): Response
    {  $authorRepo=$doctrine->getRepository(Author::class);
        $author=$authorRepo->find($id);
        $form=$this->createForm(AuthorType::class,$author); //creation form
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            ////Persistence des données
            $em=$doctrine->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('listAuthor');
        }
        return $this->render('author/editAuthor.html.twig', [
            'authorForm'=> $form->createView(),
            
        ]);

        

    }


        #[Route('/listauthors', name: 'listAuthors')]
    public function listAuthorOrderMail(AuthorRepository $authorRepo): Response
    {  
        $authors = $authorRepo->findAuthorOrderMail();
     
        

        return $this->render('author/listauthors.html.twig', [
            'authors'=> $authors, 
        ]);
    }
//dql method
//     #[Route('/ShowtBookByAuthor{id}', name: 'Show_book')]
//     public function findBookByAuthor(BookRepository $bookRepo, $id,ManagerRegistry $doctrine): Response
//     {  
//         $authorRepo=$doctrine->getRepository(Author::class);
//         $author=$authorRepo->find($id);
//         $books = $bookRepo->findBookByAuthor($id);
        
     

//         return $this->render('book/showBook.html.twig', [
//             'books'=> $books, 
//             'author'=>$author,
//         ]);
//    }

   //QB method

   #[Route('/ShowtBookByAuthor{id}', name: 'Show_book')]
    public function showAllStudentsByClassroom(BookRepository $bookRepo, $id,ManagerRegistry $doctrine): Response
    {  
        $authorRepo=$doctrine->getRepository(Author::class);
        $author=$authorRepo->find($id);
        $books = $bookRepo->showAllBooksByAuthor($id);
        
     

        return $this->render('book/showBook.html.twig', [
            'books'=> $books, 
            'author'=>$author,
        ]);
   }
    }


