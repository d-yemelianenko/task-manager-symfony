<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Task;
use App\Entity\TaskPriority;
use App\Entity\TaskStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('pl_PL');

        $userRepository = $manager->getRepository(User::class);
        $taskStatusRepository = $manager->getRepository(TaskStatus::class); // Dodaj repozytorium dla TaskStatus
        $priorities = $manager->getRepository(TaskPriority::class)->findAll();

        $users = $userRepository->findAll();
        $taskStatuses = $taskStatusRepository->findAll(); // Pobierz wszystkie statusy

        if (empty($users)) {
            $user = new User();
            $user->setEmail('admin@example.com');
            $user->setPassword('$2y$13$...'); // zahashowane hasło
            $manager->persist($user);
            $manager->flush();
            $users = [$user];
        }
        for ($i = 0; $i < 20; $i++) {
            $task = new Task();
            $task->setTitle($faker->sentence(4));
            $task->setDescription($faker->paragraph(3));
            $task->setUser($users[array_rand($users)]);


            $randomStatus = $taskStatuses[array_rand($taskStatuses)];
            $task->setTaskStatusById($randomStatus->getId(), $manager);

            $createdAt = $faker->dateTimeBetween('-30 days', 'now');
            $task->setCreatedAt(\DateTimeImmutable::createFromMutable($createdAt));


            $dueDate = $faker->dateTimeBetween(
                $createdAt->modify('+1 hour'),
                $createdAt->modify('+30 days')
            );
            $task->setDueDate(\DateTimeImmutable::createFromMutable($dueDate));



            if ($faker->boolean(50) && count($priorities) > 0) {
                $randomPriority = $faker->randomElement($priorities);
                $task->setPriority($randomPriority);
            }

            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TaskPriorityFixtures::class,
        ];
    }
}
