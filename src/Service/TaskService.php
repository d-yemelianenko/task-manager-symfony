<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\TaskRepository;
use App\Entity\Task;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskService
{
    public function __construct(
        private TaskRepository $taskRepository
    ) {}

    public function getTasksForUser(User $user): array
    {
        return $this->taskRepository->findBy([
            'user' => $user
        ]);
    }

    public function getTaskForUserOrFail(int $taskId, User $user): Task
    {
        $task = $this->taskRepository->findOneByIdAndUser($taskId, $user);

        if (!$task) {
            throw new NotFoundHttpException('Task nie istnieje lub nie masz do niego dostępu');
        }
        return $task;
    }
}
