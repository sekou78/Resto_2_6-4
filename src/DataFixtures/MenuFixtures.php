<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MenuFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $menu = (new Menu())
                ->setUuid(random_int(150,850))
                ->setTitle("Mon titre Menu $i")
                ->setDescription("Mon description Menu $i")
                ->setPrice(random_int(5,20))
                ->setRestaurant($this->getReference("restaurant" . random_int(1,10)))
                ->setCreatedAt(new DateTimeImmutable());

            // Associer des catégories au menu
            // Ici, on associe 1 catégories aléatoires à chaque menu pour l'exemple
            for ($j = 1; $j <= 1; $j++) {
                $category = $this->getReference(CategoryFixtures::CATEGORY_REFERENCE . random_int(1, 10));
                $menu->addCategory($category);
            }

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