<?php

namespace App\Controller;

use App\Entity\Liste;
use App\Form\ListeType;
use App\Repository\ListeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ListeController extends AbstractController
{
    /**
     * @Route("/", name="liste_index", methods={"GET"})
     */
    public function index(ListeRepository $listeRepository): Response
    {
        return $this->render('index.html.twig', [
            'listes' => $listeRepository->findAll(),
        ]);
    }

    /**
     * @Route("liste/new", name="liste_new", methods={"GET","POST"})
     */
    public function new(Request $request): RedirectResponse
    {
        $title = $request->get('input-title');

        if ($request->isMethod('Post') && !empty($title)) {
            $liste = new Liste();
            $liste->setTitle($title);
            $em = $this->getDoctrine()->getManager();
            $em->persist($liste);
            $em->flush();
            
            return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
        } 
        
        return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("liste/{id}/edit", name="liste_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Liste $liste): RedirectResponse
    {
        $title = $request->get('input-title');

        if ($request->isMethod('Post') && !empty($title)) {
            $liste->setTitle($title);
            $em = $this->getDoctrine()->getManager();
            $em->persist($liste);
            $em->flush();
            
            return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
        } 
        
        return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("liste/{id}/delete", name="liste_delete")
     */
    public function delete(Liste $liste): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($liste);
        $em->flush();
        
        return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
      
    }
}
