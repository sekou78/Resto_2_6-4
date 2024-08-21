<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class MenuFixtures extends Fixture implements DependentFixtureInterface
{
    public const MENU_NB_TUPLES = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create("fr_FR");

        for ($i = 1; $i <= self::MENU_NB_TUPLES; $i++) {
            $menu = (new Menu())
                // ->setUuid(random_int(150,850))
                ->setUuid($faker->uuid())
                ->setTitle($faker->words(3, true))
                ->setDescription($faker->text)
                // ->setPrice(random_int(5,20))
                ->setPrice($faker->numberBetween(5, 20))
                ->setRestaurant($this->getReference(RestaurantFixtures::RESTAURANT_REFERENCE . random_int(1,10)))
                ->setCreatedAt(new DateTimeImmutable());

            // Associer des catégories au menu
            // Ici, on associe 1 catégories aléatoires à chaque menu pour l'exemple
            // for ($j = 1; $j <= 1; $j++) {
                $category = $this->getReference(CategoryFixtures::CATEGORY_REFERENCE . random_int(1, 10));
                $menu->addCategory($category);
            // }

            $manager->persist($menu);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [RestaurantFixtures::class,
                CategoryFixtures::class,
            ];
    }
}