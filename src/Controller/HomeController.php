<?php

// namespace : chemin du controller

namespace App\Controller;

use App\Repository\AdRepository;
use App\Service\Pagination;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// pour créer une page, on a besoin : 1- une fonction publique (une classe) / 2- une route (url) / 3- une réponse

class HomeController extends Controller {

    /**
     * création de notre premiere route
     * @Route("/", name="homepage")
     */

    public function home(AdRepository $adRepo,UserRepository $userRepo){

        return $this->render('home.html.twig',[
                    'ads'=>$adRepo->findAll(),
                   
                    ]);

    }

}