<?php

namespace App\DataFixtures;

use App\Entity\TaskStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $statuses = [
            ['name' => 'Do zrobienia', 'slug' => 'todo'],
            ['name' => 'W trakcie', 'slug' => 'in_progress'],
            ['name' => 'Zakończone', 'slug' => 'done']
        ];

        foreach ($statuses as $statusData) {
            $status = new TaskStatus();
            $status->setName($statusData['name'])
                ->setSlug($statusData['slug']);

            $manager->persist($status);
        }

        $manager->flush();
    }
}
