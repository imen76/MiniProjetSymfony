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
    public function index(LivreRepository $livreRepository,CategorieRepository $categorieRepository): Response
    {
        return $this->render('livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
        ]);
    }

     /**
     * @Route("/list", name="livre_list", methods={"GET"})
     */
    public function list(LivreRepository $livreRepository,CategorieRepository $categorieRepository): Response
    {
        /*$livre = $this->getDoctrine()
                      ->getRepository()
                      ->showLivreByCategorie("informatique");   */

        return new Response("Hello");

        /*return $this->render('livre/listuser.html.twig', [
            'livres' => $livreRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
        ]);*/
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
     * @Route("/showLivreByCategorie", name="showLivreByCategorie")
     */
    public function showLivreByCategorie(Request $request, CategorieRepository $categorieRepository): Response
    {
        /*$livre = $this->getDoctrine()
                      ->getRepository()
                      ->showLivreByCategorie("informatique");*/
        
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
            'categories' => $categorieRepository->findAll(),
        ]);
    }

}
