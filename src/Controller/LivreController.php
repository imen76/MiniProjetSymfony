<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Entity\Categorie;
use App\Repository\LivreRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/livre")
 */
class LivreController extends AbstractController
{
    //$categorieRepository = new CategorieRepository();

    /**
     * 
     * @Route("/", name="livre_index", methods={"GET"})
     */
    public function index(Request $request,LivreRepository $livreRepository,CategorieRepository $categorieRepository,PaginatorInterface $paginator): Response
    {
        $livre = new Livre();

        $donnees = $this->getDoctrine()->getRepository(Livre::class)->findAll();

        $livre = $paginator->paginate(

            $donnees,//passer les livres
            $request->query->getInt('page',1),
            6
        );
        return $this->render('livre/index.html.twig', [
            'livres' => $livre,
            'categories' => $categorieRepository->findAll(),

        ]);
    }

     /**
     * @Route("/list", name="livre_list", methods={"GET"})
     */
    public function list(LivreRepository $livreRepository,CategorieRepository $categorieRepository): Response
    {        
           
            return $this->render('livre/listuser.html.twig', [
                'livres' => $livreRepository->findAll(),
                'categories' => $categorieRepository->findAll(),
                
        ]);
    }

    /**
     * @Route("/new", name="livre_new", methods={"GET","POST"})
     */
    public function new(Request $request, CategorieRepository $categorieRepository): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imagebook =$form->get('image')->getData();
            var_dump($imagebook);

            if($imagebook){
                $origineimage= pathinfo($imagebook->getClientOriginalName(), PATHINFO_FILENAME); 
                
                $image=$origineimage . '-' . uniqid()  . '.' . $imagebook-> guessExtension();        
            
             try {
                $imagebook->move(
                    $this->getParameter('image_directory'),
                    $image
                );
                } catch (FileException $e) {
                //throw $th;
                }
                $livre->setImage($image);    
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('livre_index');
     }

        return $this->render('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
            'categories' => $categorieRepository->findAll(),
        ]);
    }


    /**
     * @Route("/{id}", name="livre_show", methods={"GET"})
     */
    public function show(Livre $livre, CategorieRepository $categorieRepository): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="livre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Livre $livre,CategorieRepository $categorieRepository): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('livre_index');
        }

        return $this->render('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="livre_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Livre $livre, CategorieRepository $categorieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('livre_index');
    }

    /**
     * @Route("/showLivreByCategorie/{id}", name="showLivreByCategorie")
     */
    public function showLivreByCategorie(Request $request, CategorieRepository $categorieRepository,Categorie $id): Response
    {
        /*$livre = $this->getDoctrine()
                      ->getRepository()
                      ->showLivreByCategorie("informatique");
        
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
            'categories' => $categorieRepository->findAll(),
        ]);*/
        $livres = $this->getDoctrine()->getRepository(Livre::class)->findBy(['categorie'=>$id]);        

        return $this->render('/livre/showLivreByCategorie.html.twig',[
              'livres' => $livres,
              'categories' => $categorieRepository->findAll() ,
               'categorie' =>$id
            ]);
                   
    }
      /**
      * @Route("/livre_categorie/{id}", name="livre_categorie")
      */
      public function livre_categorie(Categorie $id,CategorieRepository $categorieRepository,PaginatorInterface $paginator){
  
        $livres = $this->getDoctrine()->getRepository(Livre::class)->findBy(['categorie'=>$id]);
     
        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
            'categories' => $categorieRepository->findAll(),

        ]);
     }
    /**
     * @Route("/menu/{id}", name="menu")
     */
    public function menu(Categorie $id){
 
        // $livres = $this->getDoctrine()->getRepository(Livre::class)->findBy(['categorie'=>$id]);
        $categories=$categorieRepository()->findAll();
         
        
         return $this->render('/base1.html.twig', array(
             'categories' => $categories
         ));
     }
       

}
