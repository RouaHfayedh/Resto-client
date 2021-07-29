<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AnnonceType;
use App\Service\Pagination;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * Permet d'afficher une liste d'annonces
     * @Route("/ads{page<\d+>?1}", name="ads_list")
     */
    public function index(AdRepository $repo,Pagination $paginationService,$page){

        // via $repo, on va aller chercher toutes les annonces via la méthode findAll

        $paginationService->setEntityClass(Ad::class)
                        ->setPage($page)
                        ->setLimit(8)
                        //->setRoute('admin_ads_list')
                        ;

        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'controller_name' => 'Nos plats',
            'pagination'=>$paginationService,
            'ads'=>$ads
        ]);
    }

    /**
     * permet de creer une annonce
     * @Route("/ads/new",name="ads_create")
     * @IsGranted("ROLE_USER")
     * @return response
     */

    public function create(Request $request,ObjectManager $manager){

        // fabrcant de formulaire : FORMBUILDER

        $ad = new Ad();

        // on lance la fabrication et la configuration de notre formulaire

        $form = $this->createForm(AnnonceType::class,$ad);

        // recuperation des données du formulaire
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // si le fomulaire est soumis Et si le formulaire est valide, on demande à doctrine de sauvegarder ces données dans l'objet manager( dans la bdd)
            //pour chaque image supplémentaire ajoutée

            foreach($ad->getImages() as $image){

                // on relie l'image à l'annonce et on modifie l'annonce
                $image->setAd($ad);

                // on sauvegarde les images

                $manager->persist($image);
            }

            $ad->setAuthor($this->getUser());
            $manager ->persist($ad);
            $manager->flush();

            $this->addFlash('success',"Annonce <strong>{$ad->getTitle()}</strong> créée avec succès");

            return $this->redirectToRoute('ads_single',['slug'=>$ad->getSlug()]);
        }

        return $this->render('ad/new.html.twig',['form'=>$form->createView()]);

    }

    /**
     *Permet d'afficher une seule annonce
     *@Route("/ads/{slug}", name="ads_single")

     *@return Response
     */

    public function show($slug,Ad $ad){

        // je recupere l'annonce qui correspond au slug (alias)
        // X = 1 champ de la table, à préciser à la place de X
        //findByX = renvoi un tableau d'annonces (plusieurs elements)
        //findOneByX = renvoi à un élément

        //$ad = $repo->findOneBySlug($slug);
        return $this->render('ad/show.html.twig',['ad'=>$ad]);

    }

    /**
     * Permet d'éditer et de modifier une annonce
     * @Route("/ads/{slug}/edit",name="ads_edit")
     * @Security("is_granted('ROLE_USER') and user === ad.getAuthor()",message="Cette annonce ne vous appartient pas, vous ne pouvez pas la modifier.")
     * 
     * @return response
     */
    public function edit(Ad $ad,Request $request,ObjectManager $manager){

        $form = $this->createForm(AnnonceType::class,$ad);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            foreach($ad->getImages() as $image){

                $image -> setAd($ad);

                $manager->persist($image);
            }

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash("success","Les modifications ont bien été prises en compte !");

            return $this->redirectToRoute('ads_single',['slug'=>$ad->getSlug()]);
        }

        return $this->render('ad/edit.html.twig',['form'=>$form->createView(),'ad'=>$ad]);
    }

    /**
     * Permet une suppression d'une annonce
     * @Route("/ads/{slug}/delete",name="ads_delete")
     * @Security("is_granted('ROLE_USER') and user == ad.getAuthor()",message="Cette action ne vous est pas autorisée.")
     *
     * @param Ad $ad
     * @return void
     */
    public function delete(Ad $ad,ObjectManager $manager){

        $manager->remove($ad);
        $manager->flush();
        $this->addFlash("success","L'annonce {$ad->getTitle()} a bien été supprimée.");

        return $this->redirectToRoute("account_home");

    }

}
