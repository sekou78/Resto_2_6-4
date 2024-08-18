<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHashed)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $user = (new User())
                ->setFirstname("Firstname1 $i")
                ->setLastname("Lastname1 $i")
                ->setGuestNumber(random_int(0, 10))
                ->setEmail("Email.$i@bibi.fr")
                ->setCreatedAt(new DateTimeImmutable());

            $user->setPassword($this->passwordHashed->hashPassword($user, "password$i"));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
