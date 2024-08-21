<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class RestaurantFixtures extends Fixture implements DependentFixtureInterface
{
    public const RESTAURANT_NB_TUPLES = 10;
    public const RESTAURANT_REFERENCE = "restaurant";

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= self::RESTAURANT_NB_TUPLES; $i++) {
            $restaurant = (new Restaurant())
                // ->setUuid(random_int(150,850))
                ->setUuid($faker->uuid())
                // ->setName("Mon Nom Restaurant $i")
                ->setName($faker->company())
                // ->setDescription("Mon description Restaurant $i")
                ->setDescription($faker->text())
                // ->setAmOpeningTime(["06:30"])
                ->setAmOpeningTime([$faker->amPm()])
                // ->setPmOpeningTime(["21:30"])
                ->setPmOpeningTime([$faker->time()])
                ->setMaxGuest(random_int(30,80))
                ->setOwner($this->getReference(UserFixtures::USER_REFERENCE . $i))
                ->setCreatedAt(new DateTimeImmutable());

            $manager->persist($restaurant);
            $this->addReference(self::RESTAURANT_REFERENCE . $i, $restaurant);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}