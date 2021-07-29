<?php

namespace App\Controller;



use App\Entity\Ad;
use App\Entity\Book;
use App\Entity\Comments;
use App\Form\BookType;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BookController extends AbstractController
{
    /**
     * Permet d'afficher le formulaire de reservation
     * @Route("/book",name="book_create")
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */

    public function book(Request $request,ObjectManager $manager)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class,$book);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $this->getUser();

            $book->setBooker($user)
                    ;

            // si les dates ne sont pas disponibles

           

                $manager->persist($book);
                $manager->flush();
    
                return $this->redirectToRoute("book_show",['id'=>$book->getId(),'alert'=>true]);
                
            }
                    return $this->render('book/book.html.twig', ['form'=>$form->createView()]);

        }

    

    /**
     * Affiche une reservation
     * @Route("/book/{id}",name="book_show")
     * @param Book $book
     * @return Response
     */
    public function show(Book $book,Request $request,ObjectManager $manager){

        $comment = new Comments();

        $form = $this->createForm(CommentType::class,$comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $comment->setAuthor($this->getuser());

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash("success","Votre commentaire a bien été pris en compte.");

        }

        return $this->render("book/show.html.twig",['book'=>$book,'form'=>$form->createView()]);

    }
}
