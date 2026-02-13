<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'task_index', methods: ['GET'])]
    public function index(TaskService $taskService): Response
    {
        $tasks = $taskService->getAll();

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

        #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->redirectToRoute('task_index');
    }


    #[Route('/tasks/new', name: 'task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TaskService $taskService): Response
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskService->create($task);

            $this->addFlash('success', 'Tâche ajoutée avec succès.');

            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
