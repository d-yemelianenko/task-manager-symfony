<?php

namespace App\Repository;

use App\Entity\TaskStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Task;
use Symfony\Component\HttpFoundation\Response;

/**
 * @extends ServiceEntityRepository<TaskStatus>
 */
class TaskStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskStatus::class);
    }

    public function index(TaskStatusRepository $statusRepo): Response
    {
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findAll();
        $defaultStatus = $statusRepo->find(1); // lub findOneBy(['name' => 'To Do'])

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
            'default_status' => $defaultStatus
        ]);
    }

    //    /**
    //     * @return TaskStatus[] Returns an array of TaskStatus objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TaskStatus
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
