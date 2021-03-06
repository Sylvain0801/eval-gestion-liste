<?php

namespace App\Controller;

use App\Entity\Liste;
use App\Repository\ColorRepository;
use App\Repository\ListeRepository;
use App\Repository\StatusRepository;
use DateTimeImmutable;
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
    public function index(ListeRepository $listeRepository, StatusRepository $statusRepository, ColorRepository $colorRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'listes' => $listeRepository->findBy([], ['updated_at' => 'desc']),
            'statuses' => $statusRepository->findAll(),
            'colors' => $colorRepository->findAll(),
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
            $liste->setUpdated_at(new DateTimeImmutable());
            $em = $this->getDoctrine()->getManager();
            $em->persist($liste);
            $em->flush();
            $this->addFlash('message_alert', "La liste &ldquo;$title&rdquo; a été créée avec succès");
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
            $liste->setUpdated_at(new DateTimeImmutable());
            $em = $this->getDoctrine()->getManager();
            $em->persist($liste);
            $em->flush();
            
            $this->addFlash('message_alert', "La liste &ldquo;$title&rdquo; a été modifiée avec succès");
            return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
        } 
        
        return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("liste/{id}/delete", name="liste_delete")
     */
    public function delete(Liste $liste): RedirectResponse
    {
        $title = $liste->getTitle();
        $this->addFlash('message_alert', "La liste &ldquo;$title&rdquo; a été supprimée avec succès");
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($liste);
        $em->flush();
        
        return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
      
    }
}
