<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public const BOOKING_NB_TUPLES = 10;

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
        $faker = Faker\Factory::create("fr_FR");

        for ($i = 1; $i <= self::BOOKING_NB_TUPLES; $i++) {
            $booking = (new Booking())
                ->setUuid($faker->uuid())
                ->setGuestNumber($faker->numberBetween(30, 80))
                ->setOrderDate($this->getRandomDate())
                ->setOrderHour($this->getRandomHour())
                ->setAllergy($faker->words(1, true))
                ->setRestaurant($this->getReference(RestaurantFixtures::RESTAURANT_REFERENCE . random_int(1,10)))
                ->setClient($this->getReference(UserFixtures::USER_REFERENCE . random_int(1,10)))
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