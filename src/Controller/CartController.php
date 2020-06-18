<?php

namespace App\Controller;
use App\Entity\Livre;
use App\Repository\LivreRepository;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_panier")
     */
    public function index(SessionInterface $session, LivreRepository $livreRepository,CategorieRepository $categorieRepository)
    {
        $panier = $session->get('panier',[]);
        $panierWithData = [];
        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                 'livre'  => $livreRepository->find($id), 
                 'quantity'=> $quantity,
                 'categories' => $categorieRepository->findAll(),
            ]; 
        }
        $total = 0;
        foreach($panierWithData as $item){
            $totalItem = $item['livre']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }


        return $this->render('cart/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */   
    public function add($id, SessionInterface $session)
    {
        
        $panier = $session->get('panier', []);
        if(!empty($panier[$id])) {
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }
        
        $session->set('panier', $panier);
    
        return $this->redirectToRoute('cart_panier');
        ///dd($session->get('panier'));
    }
    }
