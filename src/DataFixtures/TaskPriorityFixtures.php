<?php

namespace App\DataFixtures;

use App\Entity\TaskPriority;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskPriorityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $priorities = [
            ['name' => 'Niski', 'level' => 'low'],
            ['name' => 'Średni', 'level' => 'medium'],
            ['name' => 'Wysoki', 'level' => 'high'],
            ['name' => 'Krytyczny', 'level' => 'critical'],
        ];

        foreach ($priorities as $data) {
            $priority = new TaskPriority();
            $priority->setName($data['name']);
            $priority->setLevel($data['level']);
            $manager->persist($priority);

            // Dodaj reference jeśli będziesz potrzebować w innych fixtures
            $this->addReference('priority_' . $data['level'], $priority);
        }

        $manager->flush();
    }
}
