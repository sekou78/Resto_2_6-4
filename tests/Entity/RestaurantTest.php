<?php

namespace App\Tests\Entity;

use App\Entity\Restaurant;
use PHPUnit\Framework\TestCase;

class RestaurantTest extends TestCase
{
    public function provideFirstName(): \Generator
    {
        yield ['The Best'];
        yield ['Le Cornu'];
    }
    /** @dataProvider provideFirstName */
    public function testFirstNameSetter(string $name): void
    {
        $restaurant = new Restaurant;
        $restaurant->setName($name);
        $this->assertSame($name, $restaurant->getName());
    }


    public function provideTestDescriptionRestos(): \Generator
    {
        yield ["Le meilleuir des restos"];
        yield ["Manger pour pas cher"];
    }
    /** @dataProvider provideTestDescriptionRestos */
    public function testDescriptionRestos(string $description): void
    {
        $restaurant = new Restaurant;
        $restaurant->setDescription($description);
        $this->assertSame($description, $restaurant->getDescription());
    }

    // public function testAnException(): void
    // {
    //     $this->expectException(\TypeError::class);
    //     $restaurant = new Restaurant();
    //     $restaurant->setDescription(10);
    // }
}