<?php

namespace App\Service;

use Twig\Environment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;

class Pagination{

    
    private $entityClass;
    private $limit=8;
    private $currentPage=1;

    private $manager;

    private $twig;
    private $route;

    private $templatePath;

    public function __construct(ObjectManager $manager,Environment $twig,RequestStack $request,$templatePath){

        $this->route = $request->getCurrentRequest()->attributes->get('_route');
        $this->manager = $manager;
        $this->twig = $twig;
        
        $this->templatePath = $templatePath;

    }

    public function display(){

        // appelle le moteur de rendu twig et on precise quel template on veut utiliser

        $this->twig->display($this->templatePath,[
            //options necessaires a l affichage des donnees
            // variables : route / page / pages
            'page'=>$this->currentPage,
            'pages'=>$this->getPages(),
            'route'=>$this->route
        ]);

    }
    
    // 1- utiliser la pagination a partir de n'importe quelle entité(controleur) / on devra preciser l'entite ou controleur concerné

    public function setEntityClass($entityClass){

        // ma donnee entityClass = donnee qui va m etre envoyée

        $this->entityClass = $entityClass;

        return $this;

    }

    public function getEntityClass(){

        return $this->entityClass;

    }

    // 2- Quelle est la limite ?

    public function getLimit(){

        return $this->limit;

    }

    public function setLimit($limit){

        $this->limit = $limit;

        return $this;

    }

    // 3- sur quelle page je me trouve actuellement ?

    public function getPage(){

        return $this->currentPage;

    }

    public function setPage($page){

        $this->currentPage = $page;
        
        return $this;

    }

    // 4- on va chercher le nombre de page au total

    public function getData(){

        if(empty($this->entityClass)){

            throw new \Exception("setEntityClass n'a pas été renseignée dans le controller correspondant");
        }

        // calcul de l offset

        $offset = $this->currentPage * $this->limit - $this->limit;

        // demande au repository de trouver les elements
        // on va chercher le bon repository

        $repo = $this->manager->getRepository($this->entityClass);

        // on construit notre requete

        $data = $repo->findBy([],[],$this->limit,$offset);

        return $data;

    }

    public function getPages(){

        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());
        $pages = ceil($total / $this->limit);

        return $pages;

    }
    
    public function getRoute(){

        return $this->route;

    }

    public function setRoute($route){

        $this->route = $route;
        return $this;

    }

    public function getTemplatePath(){

        return $this->templatePath;

    }

    public function setTemplatePath($templatePath){

        $this->templatePath = $templatePath;
        return $this;

    }
}