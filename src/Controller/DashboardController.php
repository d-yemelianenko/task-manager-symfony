<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Faker\Core\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(TaskRepository $taskRepository): Response
    {
        $user = $this->getUser();


        $totalTasks = $taskRepository->count(['user' => $user]);

        $completedTasks = $taskRepository->count([
            'user' => $user,
            'taskStatus' => 3
        ]);

        $startOfDay = new \DateTimeImmutable('today'); // 2024-01-15 00:00:00
        $endOfDay = $startOfDay->modify('+1 day');     // 2024-01-16 00:00:00

        $todayTasks = $taskRepository->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.user = :user')
            ->andWhere('t.dueDate >= :startOfDay AND t.dueDate < :endOfDay')
            ->setParameter('user', $user)
            ->setParameter('startOfDay', $startOfDay)
            ->setParameter('endOfDay', $endOfDay)
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('dashboard/dashboard.html.twig', [
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'today_tasks' => $todayTasks,
        ]);
    }
}
