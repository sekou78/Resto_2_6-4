<?php

// namespace App\Entity;

// use PHPUnit\Framework\TestCase;

// class FoodTest extends TestCase
// {
//     public function provideFirstName(): \Generator
//     {
//         yield ['The Best'];
//         yield ['Le Cornu'];
//     }
//     /** @dataProvider provideFirstName */
//     public function testFirstNameSetter(string $title): void
//     {
//         $food = new Food;
//         $food->setTitle($title);
//         $this->assertSame($title, $food->getTitle());
//     }


//     public function provideTestDescriptionRestos(): \Generator
//     {
//         yield ["Le meilleuir des restos"];
//         yield ["Manger pour pas cher"];
//     }
//     /** @dataProvider provideTestDescriptionRestos */
//     public function testDescriptionRestos(string $description): void
//     {
//         $food = new Food;
//         $food->setDescription($description);
//         $this->assertSame($description, $food->getDescription());
//     }

//     public function provideTestFoodPrice(): \Generator
//     {
//         yield [65];
//         yield [15];
//     }
//     /** @dataProvider provideTestFoodPrice */
//     public function testFoodPrice(int $price): void
//     {
//         $food = new Food;
//         $food->setPrice($price);
//         $this->assertSame($price, $food->getPrice());
//     }


//     public function testAnException(): void
//     {
//         $this->expectException(\TypeError::class);
//         $food = new Food();
//         $food->setPrice("10");
//     }
// }