<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;

class TaskService
{
    public function __construct(
        private readonly TaskRepository $taskRepository
    ) {}

    public function create(Task $task): void
    {
        // Ici tu peux mettre de la logique métier plus tard si besoin
        $this->taskRepository->add($task, true);
    }

    /**
     * @return Task[]
     */
    public function getAll(): array
    {
        return $this->taskRepository->findAllOrderedByCreatedAtDesc();
    }
}
