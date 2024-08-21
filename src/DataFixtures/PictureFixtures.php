<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PictureFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public const PICTURE_NB_TUPLES = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create("fr_FR");

        for ($i = 1; $i <= self::PICTURE_NB_TUPLES; $i++) {
            // $restaurant = $this->getReference("restaurant" . random_int(1,10));
            // $restaurant = $this->getReference(RestaurantFixtures::RESTAURANT_REFERENCE . random_int(1,10));

            $picture = (new Picture())
                // ->setTitle("Mon titre Picture $i")
                ->setTitle($faker->words(1, true))
                // ->setSlug("Mon slug Picture $i")
                ->setSlug($faker->slug())
                ->setRestaurant($this->getReference(RestaurantFixtures::RESTAURANT_REFERENCE . random_int(1,10)))
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

    public static function getGroups(): array
    {
        return ["pictureGroup"];
    }
}