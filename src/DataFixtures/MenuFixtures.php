<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=10; $i++) {
            $menu = (new Menu())
                ->setUuid(random_int(150,850))
                ->setTitle("Mon titre Menu $i")
                ->setDescription("Mon description Menu $i")
                ->setPrice(random_int(5,20))
                ->setCreatedAt(new DateTimeImmutable());

            $manager->persist($menu);
        }

        $manager->flush();
    }
}