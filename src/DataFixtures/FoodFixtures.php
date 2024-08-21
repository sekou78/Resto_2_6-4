<?php

namespace App\DataFixtures;

use App\Entity\Food;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class FoodFixtures extends Fixture implements DependentFixtureInterface
{
    public const FOOD_NB_TUPLES = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create("fr_FR");

        for ($i = 1; $i <= self::FOOD_NB_TUPLES; $i++) {
            $food = (new Food())
                ->setUuid($faker->uuid())
                ->setTitle($faker->words(3, true))
                ->setDescription($faker->text())
                ->setPrice($faker->numberBetween(7, 15))
                ->setCreatedAt(new DateTimeImmutable());

            // Associer des catégories au menu
            // Ici, on associe 1 catégories aléatoires à chaque menu pour l'exemple
            // for ($s = 1; $s <= 1; $s++) {
                $category = $this->getReference(CategoryFixtures::CATEGORY_REFERENCE . random_int(1,10));
                $food->addCategory($category);
            // }

            $manager->persist($food);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}