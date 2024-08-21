<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('LuniiiKzz');
        $user->setEmail('test@test.com');
        $user->setRoles(['ROLE_USER']);

        // Hasher le mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'test123' // Mot de passe en clair (à hasher)
        );
        $user->setPassword($hashedPassword);

        $user->setDateJoined(new \DateTime('now'));
        $user->setAvatar(null); // Optionnel, tu peux mettre une valeur si nécessaire
        $user->setActive(true);

        // Persist et flush
        $manager->persist($user);

        $manager->flush();
    }
}
