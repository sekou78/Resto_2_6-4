<?php

namespace App\DataFixtures;

use App\Entity\Food;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FoodFixtures extends Fixture implements DependentFixtureInterface
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

            // Associer des catégories au menu
            // Ici, on associe 1 catégories aléatoires à chaque menu pour l'exemple
            for ($s = 1; $s <= 1; $s++) {
                $category = $this->getReference(CategoryFixtures::CATEGORY_REFERENCE . random_int(1,10));
                $food->addCategory($category);
            }

            $manager->persist($food);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}