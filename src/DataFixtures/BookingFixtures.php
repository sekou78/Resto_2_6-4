<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookingFixtures extends Fixture
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
                ->setCreatedAt(new DateTimeImmutable());

            $manager->persist($booking);
        }

        $manager->flush();
    }
}