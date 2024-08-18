<?php

namespace App\DataFixtures;

use App\Entity\Food;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FoodFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=10; $i++) {
            $food = (new Food())
                ->setUuid(random_int(150,850))
                ->setTitle("Mon titre Food $i")
                ->setDescription("Mon description Food $i")
                ->setPrice(random_int(7,18))
                ->setCreatedAt(new DateTimeImmutable());

            $manager->persist($food);
        }

        $manager->flush();
    }
}