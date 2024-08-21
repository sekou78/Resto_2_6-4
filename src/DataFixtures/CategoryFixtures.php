<?php

namespace App\DataFixtures;

use App\Entity\Category;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_NB_TUPLES = 10;
    public const CATEGORY_REFERENCE = 'category';
    
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create("fr_FR");

        for ($i = 1; $i <= self::CATEGORY_NB_TUPLES; $i++) {
            $category = (new Category())
                ->setUuid($faker->uuid())
                ->setTitle($faker->words(3, true))
                ->setCreatedAt(new DateTimeImmutable());

            // Enregistrer une référence pour pouvoir y accéder dans MenuFixtures
            $this->addReference(self::CATEGORY_REFERENCE . $i, $category);

            $manager->persist($category);
        }

        $manager->flush();
    }
}