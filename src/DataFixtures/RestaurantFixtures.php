<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RestaurantFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=10; $i++) {
            $restaurant = (new Restaurant())
                ->setUuid(random_int(150,850))
                ->setName("Mon Nom Restaurant $i")
                ->setDescription("Mon description Restaurant $i")
                ->setAmOpeningTime(["06:30"])
                ->setPmOpeningTime(["21:30"])
                ->setMaxGuest(random_int(30,80))
                ->setOwner($this->getReference("user$i"))
                ->setCreatedAt(new DateTimeImmutable());

            $manager->persist($restaurant);
            $this->addReference("restaurant$i", $restaurant);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}