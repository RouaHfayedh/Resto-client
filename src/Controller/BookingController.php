<?php

namespace App\Controller;



use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Entity\Comments;
use App\Form\BookingType;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BookingController extends AbstractController
{
    /**
     * Permet d'afficher le formulaire de reservation
     * @Route("/ads/{slug}/book",name="booking_create")
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */

    public function book(Ad $ad,Request $request,ObjectManager $manager)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class,$booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $this->getUser();

            $booking->setBooker($user)
                    ->setAd($ad)
                    ;
        //     //Create new customer
        //     $customer = \Stripe\Customer::create([
        //         'email' => $user->getEmail()
        //     ]);
          

        //     //Create new card for customer
        //     $card = $customer->sources->create([
        //         'source' => [
        //             'object' => 'card',
        //             'exp_month' => '12',
        //             'exp_year' => '2020',
        //             'number' => '4242424242424242',
        //             'cvc' => '123',
        //             'tokenization_method'=>null
                   
        //         ]
        //     ]);
        // dump($card);
        // die();
        //     //Create payment with customer card
        //     $charge = \Stripe\Charge::create([
        //         'customer' => $user->getId(),
        //         'amount' => $booking->getAmount(),
        //         'currency' => 'eur',
        //         'source' => $booking->getId()
        //     ]);

        //     dump($charge);
        //     die();

            // si les dates ne sont pas disponibles

            //if(!$booking->isBookableDays()){

               // $this->addFlash("warning","Ces dates ne sont pas disponibles, veuillez choisir d'autres dates pour votre séjour");

           // }else{

                $manager->persist($booking);
                $manager->flush();
    
                return $this->redirectToRoute("booking_show",['id'=>$booking->getId(),'alert'=>true]);

            

        }

        return $this->render('booking/booking.html.twig', [
            'ad'=>$ad,
            'form'=>$form->createView()
        ]);
    }

    /**
     * Affiche une reservation
     * @Route("/booking/{id}",name="booking_show")
     * @param Booking $booking
     * @return Response
     */
    public function show(Booking $booking,Request $request,ObjectManager $manager){

        $comment = new Comments();

        $form = $this->createForm(CommentType::class,$comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $comment->setAd($booking->getAd())
                    ->setAuthor($this->getuser());

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash("success","Votre commentaire a bien été pris en compte.");

        }

        return $this->render("booking/show.html.twig",['booking'=>$booking,'form'=>$form->createView()]);

    }


}
