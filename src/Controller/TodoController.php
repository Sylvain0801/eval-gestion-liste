<?php

namespace App\Controller;

use App\Entity\Color;
use App\Entity\Liste;
use App\Entity\Status;
use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
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
        $title = $request->get("new_todo_title_$id");
        $description = $request->get("new_todo_description_$id");

        if (empty($title) || empty($description)) {
            return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
        }

        $liste = $this->getDoctrine()->getRepository(Liste::class)->findOneBy(['id' => $id]);
        $status = $this->getDoctrine()->getRepository(Status::class)->findOneBy(['id' => $request->get("statuses_new_$id")]);
        $color = $this->getDoctrine()->getRepository(Color::class)->findOneBy(['id' => $request->get("colors_new_$id")]);

        $todo = new Todo();
        $todo
            ->setTitle($title)
            ->setDescription($description)
            ->setListe($liste)
            ->setStatus($status)
            ->setColor($color);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($todo);
        $em->flush();

        return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
        
    }

    /**
     * @Route("todo/{id}/edit", name="todo_edit")
     */
    public function edit(Request $request, Todo $todo): Response
    {
        $id = $todo->getId();
        $title = $request->get("edit_todo_title_$id");
        $description = $request->get("edit_todo_description_$id");

        if (empty($title) || empty($description)) {
            return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
        }

        $liste = $this->getDoctrine()->getRepository(Liste::class)->findOneBy(['id' => $id]);
        $status = $this->getDoctrine()->getRepository(Status::class)->findOneBy(['id' => $request->get("statuses_edit_$id")]);
        $color = $this->getDoctrine()->getRepository(Color::class)->findOneBy(['id' => $request->get("colors_edit_$id")]);

        $todo
            ->setTitle($title)
            ->setDescription($description)
            ->setStatus($status)
            ->setColor($color);

        $em = $this->getDoctrine()->getManager();
        $em->persist($todo);
        $em->flush();

        return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("todo/{id}/delete", name="todo_delete")
     */
    public function delete(Todo $todo): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($todo);
        $em->flush();
        
        return $this->redirectToRoute('liste_index', [], Response::HTTP_SEE_OTHER);
    }
}
