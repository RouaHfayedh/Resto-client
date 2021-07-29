<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Book;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function GetUsers(Request $request,SerializerInterface $serializer) : Response
    {
        $users=$this->getDoctrine()->getRepository(User::class)->findAll();
        $response = new Response( $serializer->serialize(
            $users,
            'json', ['groups' => ['default' ]]
        ));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    /**
     * @Route("/user/{id}", name="userByID")
     */
    public function index(Request $request,SerializerInterface $serializer,$id) : Response
    {
        $user=$this->getDoctrine()->getRepository(User::class)->find($id);
        $response = new Response(json_encode(array('user'=>$serializer->serialize(
            $user,
            'json', ['groups' => ['default' ]]
        ))));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }
}

