<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public const USER_NB_TUPES = 10;
    public const USER_REFERENCE = "user";

    public function __construct(private UserPasswordHasherInterface $passwordHashed)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= self::USER_NB_TUPES; $i++) {
            $user = (new User())
                // ->setFirstname("Firstname1 $i")
                ->setFirstname($faker->firstName())
                // ->setLastname("Lastname1 $i")
                ->setLastname($faker->lastName())
                // ->setGuestNumber(random_int(0, 10))
                ->setGuestNumber($faker->numberBetween(20,100))
                // ->setEmail("Email.$i@bibi.fr")
                ->setEmail($faker->email())
                // ->setAllergy("gluten $i")
                ->setAllergy($faker->words(1, true))
                ->setCreatedAt(new DateTimeImmutable());

            $user->setPassword($this->passwordHashed->hashPassword($user, "password$i"));

            $manager->persist($user);
            $this->addReference(self::USER_REFERENCE . $i, $user);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ["userGroup"];
    }
}
