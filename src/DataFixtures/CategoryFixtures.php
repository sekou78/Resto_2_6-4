<?php

namespace App\DataFixtures;

use App\Entity\Category;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=10; $i++) {
            $category = (new Category())
                ->setUuid(random_int(150,850))
                ->setTitle("Mon titre Category $i")
                ->setCreatedAt(new DateTimeImmutable());

            $manager->persist($category);
        }

        $manager->flush();
    }
}