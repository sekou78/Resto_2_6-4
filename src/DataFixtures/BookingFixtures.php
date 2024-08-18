<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=10; $i++) {
            $booking = (new Booking())
                ->setUuid(random_int(150,850))
                ->setGuestNumber(random_int(20,80))
                ->setOrderDate(new DateTimeImmutable())
                ->setOrderHour(new DateTimeImmutable())
                ->setAllergy("Cacahuètes $i")
                ->setClient($this->getReference("user" . random_int(1,10)))
                ->setCreatedAt(new DateTimeImmutable());

            $manager->persist($booking);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}