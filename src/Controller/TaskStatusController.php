<?php

namespace App\Controller;

use App\Entity\TaskStatus;
use App\Form\TaskStatusForm;
use App\Repository\TaskStatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/status')]
final class TaskStatusController extends AbstractController
{
    #[Route(name: 'app_task_status_index', methods: ['GET'])]
    public function index(TaskStatusRepository $taskStatusRepository): Response
    {
        return $this->render('task_status/index.html.twig', [
            'task_statuses' => $taskStatusRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_task_status_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $taskStatus = new TaskStatus();
        $form = $this->createForm(TaskStatusForm::class, $taskStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($taskStatus);
            $entityManager->flush();

            return $this->redirectToRoute('app_task_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task_status/new.html.twig', [
            'task_status' => $taskStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_status_show', methods: ['GET'])]
    public function show(TaskStatus $taskStatus): Response
    {
        return $this->render('task_status/show.html.twig', [
            'task_status' => $taskStatus,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_status_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TaskStatus $taskStatus, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskStatusForm::class, $taskStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_task_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task_status/edit.html.twig', [
            'task_status' => $taskStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_status_delete', methods: ['POST'])]
    public function delete(Request $request, TaskStatus $taskStatus, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taskStatus->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($taskStatus);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_task_status_index', [], Response::HTTP_SEE_OTHER);
    }
}
