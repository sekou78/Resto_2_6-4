<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PictureFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=10; $i++) {
            // $restaurant = $this->getReference("restaurant" . random_int(1,10));

            $picture = (new Picture())
                ->setTitle("Mon titre Picture $i")
                ->setSlug("Mon slug Picture $i")
                ->setRestaurant($this->getReference("restaurant" . random_int(1,10)))
                // ->setRestaurant($restaurant)
                ->setCreatedAt(new DateTimeImmutable());

            $manager->persist($picture);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [RestaurantFixtures::class];
    }
}