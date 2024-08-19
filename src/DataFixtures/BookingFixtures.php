<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    private function getRandomDate(): DateTimeImmutable
    {
        // Génère une date aléatoire entre 30 jours dans le passé et aujourd'hui
        $timestamp = random_int(
            strtotime('-30 days'),
            strtotime('now')
        );

        return new DateTimeImmutable(date('d-m-Y', $timestamp));
    }

    private function getRandomHour(): DateTimeImmutable
    {
        // Génère une heure aléatoire dans une journée
        $hour = random_int(8, 20); // Par exemple, entre 08:00 et 20:00
        $minute = random_int(0, 59);

        // Utilise la date d'aujourd'hui avec l'heure générée aléatoirement
        return new DateTimeImmutable(sprintf('%s %02d:%02d:00', date('d-m-Y'), $hour, $minute));
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=10; $i++) {
            $booking = (new Booking())
                ->setUuid(random_int(150,850))
                ->setGuestNumber(random_int(20,80))
                ->setOrderDate($this->getRandomDate())
                ->setOrderHour($this->getRandomHour())
                ->setAllergy("Cacahuètes $i")
                ->setRestaurant($this->getReference("restaurant" . random_int(1,10)))
                ->setClient($this->getReference("user" . random_int(1,10)))
                ->setCreatedAt(new DateTimeImmutable());

            $manager->persist($booking);
        }

        $manager->flush();
    }

    public function getDependencies(): array
{
    return [
        RestaurantFixtures::class,
        UserFixtures::class,
    ];
}
}