<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

     /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {
        return $this->render('home/accueil.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/home/list", name="accueil")
     */
    public function list()
    {
        return $this->render('home/list.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
     /**
     * @Route("/home/new", name="affiche_article")
     */
    public function affiche()
    {
        $categorie =   $this->getDoctrine()
                            ->getRepository('App:Categorie')
                            ->getNomCategorie();

        $stringCategorie = implode("|",$categorie);
        echo "he".$stringCategorie;
        return new Response("hello categorie ".$stringCategorie);
        /*return $this->render('home/affiche_article.html.twig', [
            'controller_name' => 'HomeController',
        ]);*/
    }

    

}
