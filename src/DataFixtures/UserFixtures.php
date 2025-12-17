<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private \App\Repository\UserRepository $userRepository
    ) {}

    public function load(ObjectManager $manager): void
    {
        $existingUser = $this->userRepository->findOneBy(['email' => 'admin@example.com']);

        if (!$existingUser) {
            $user = new User();
            $user->setEmail('admin@example.com');
            $user->setPassword('$2y$13$...');
            $manager->persist($user);
        }

        $manager->flush();
    }
}
