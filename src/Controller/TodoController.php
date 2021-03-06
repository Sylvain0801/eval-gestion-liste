<?php

namespace App\Controller;

use App\Entity\Color;
use App\Entity\Liste;
use App\Entity\Status;
use App\Entity\Todo;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TodoController extends AbstractController
{
    /**
     * @Route("todo/new/{id}", name="todo_new")
     */
    public function new($id, Request $request): Response
    {
        $title = $request->get("todo_title");
        $description = $request->get("todo_description");

        if (empty($title) || empty($description)) {
            return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
        }

        $liste = $this->getDoctrine()->getRepository(Liste::class)->findOneBy(['id' => $id]);
        $titleListe = $liste->getTitle();
        $status = $this->getDoctrine()->getRepository(Status::class)->findOneBy(['id' => $request->get("statuses")]);
        $color = $this->getDoctrine()->getRepository(Color::class)->findOneBy(['id' => $request->get("colors")]);

        $todo = new Todo();
        $todo
            ->setTitle($title)
            ->setDescription($description)
            ->setListe($liste)
            ->setStatus($status)
            ->setColor($color);
        $liste->setUpdated_at(new DateTimeImmutable());
        $em = $this->getDoctrine()->getManager();
        $em->persist($todo);
        $em->flush();

        $this->addFlash('message_alert', "La tâche &ldquo;$title&rdquo; de la liste &ldquo;$titleListe&rdquo; a été créée avec succès");
        return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
        
    }

    /**
     * @Route("todo/{id}/edit", name="todo_edit")
     */
    public function edit(Request $request, Todo $todo): Response
    {
        $id = $todo->getId();
        $title = $request->get("todo_title");
        $description = $request->get("todo_description");

        if (empty($title) || empty($description)) {
            return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
        }

        $liste = $todo->getListe();
        $titleListe = $liste->getTitle();
        $status = $this->getDoctrine()->getRepository(Status::class)->findOneBy(['id' => $request->get("statuses")]);
        $color = $this->getDoctrine()->getRepository(Color::class)->findOneBy(['id' => $request->get("colors")]);

        $todo
            ->setTitle($title)
            ->setDescription($description)
            ->setStatus($status)
            ->setColor($color);
            
        $liste->setUpdated_at(new DateTimeImmutable());
        $em = $this->getDoctrine()->getManager();
        $em->persist($todo);
        $em->persist($liste);
        $em->flush();

        $this->addFlash('message_alert', "La tâche &ldquo;$title&rdquo; de la liste &ldquo;$titleListe&rdquo; a été modifiée avec succès");
        return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("todo/{id}/delete", name="todo_delete")
     */
    public function delete(Todo $todo): RedirectResponse
    {
        $title = $todo->getTitle();
        $titleListe = $todo->getListe()->getTitle();
        $this->addFlash('message_alert', "La tâche &ldquo;$title&rdquo; de la liste &ldquo;$titleListe&rdquo; a été supprimée avec succès");

        $em = $this->getDoctrine()->getManager();
        $em->remove($todo);
        $em->flush();
        
        return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
    }
}
