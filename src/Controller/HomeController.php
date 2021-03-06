<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\route;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;



class HomeController extends AbstractController
{
    /**
     * @Route("/", name="categorie_home", methods={"GET"})
     */
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }
    

}
