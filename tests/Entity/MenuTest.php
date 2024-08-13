<?php

namespace App\Entity;

use PHPUnit\Framework\TestCase;

class MenuTest extends TestCase
{
    public function provideTestMenuPrice(): \Generator
    {
        yield [65];
        yield [15];
    }
    /** @dataProvider provideTestMenuPrice */
    public function testMenuPrice(int $price): void
    {
        $menu = new Menu;
        $menu->setPrice($price);
        $this->assertSame($price, $menu->getPrice());
    }


    // public function testAnException(): void
    // {
    //     $this->expectException(\TypeError::class);
    //     $restaurant = new Menu();
    //     $restaurant->setPrice("10");
    // }
}