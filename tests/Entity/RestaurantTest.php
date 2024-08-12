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
}