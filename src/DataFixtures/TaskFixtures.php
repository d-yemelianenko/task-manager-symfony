<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Task;
use App\Entity\TaskPriority;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('pl_PL');

        $users = $manager->getRepository(User::class)->findAll();
        $priorities = $manager->getRepository(TaskPriority::class)->findAll();

        for ($i = 0; $i < 20; $i++) {
            $task = new Task();
            $task->setTitle($faker->sentence(4));
            $task->setDescription($faker->paragraph(3));
            
            $randomUser = $faker->randomElement($users);
            $task->setUser($randomUser);

            // KONWERSJA DateTime → DateTimeImmutable
            $dueDate = $faker->dateTimeBetween('now', '+30 days');
            $task->setDueDate(\DateTimeImmutable::createFromMutable($dueDate));

            $createdAt = $faker->dateTimeBetween('-30 days', 'now');
            $task->setCreatedAt(\DateTimeImmutable::createFromMutable($createdAt));


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
