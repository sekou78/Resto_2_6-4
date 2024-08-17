<?php

// namespace App\Tests\Entity;

// use App\Entity\Restaurant;
// use PHPUnit\Framework\TestCase;

// class RestaurantTest extends TestCase
// {
//     public function provideFirstName(): \Generator
//     {
//         yield ['The Best'];
//         yield ['Le Cornu'];
//     }
//     /** @dataProvider provideFirstName */
//     public function testFirstNameSetter(string $name): void
//     {
//         $restaurant = new Restaurant;
//         $restaurant->setName($name);
//         $this->assertSame($name, $restaurant->getName());
//     }


//     public function provideTestDescriptionRestos(): \Generator
//     {
//         yield ["Le meilleuir des restos"];
//         yield ["Manger pour pas cher"];
//     }
//     /** @dataProvider provideTestDescriptionRestos */
//     public function testDescriptionRestos(string $description): void
//     {
//         $restaurant = new Restaurant;
//         $restaurant->setDescription($description);
//         $this->assertSame($description, $restaurant->getDescription());
//     }

//     public function provideTestAmOpeningTimeRestos(): \Generator
//     {
//         yield [["07:00", "10:30"]];
//     }
//     /** @dataProvider provideTestAmOpeningTimeRestos */
//     public function testAmOpeningTimeRestos(array $amOpening): void
//     {
//         $restaurant = new Restaurant;
//         $restaurant->setAmOpeningTime($amOpening);
//         $this->assertSame($amOpening, $restaurant->getAmOpeningTime());
//     }

//     public function provideTestPmOpeningTimeRestos(): \Generator
//     {
//         yield [["18:30", "01:30"]];
//     }
//     /** @dataProvider provideTestPmOpeningTimeRestos */
//     public function testPmOpeningTimeRestos(array $PmOpening): void
//     {
//         $restaurant = new Restaurant;
//         $restaurant->setPmOpeningTime($PmOpening);
//         $this->assertSame($PmOpening, $restaurant->getPmOpeningTime());
//     }

//     public function testAnException(): void
//     {
//         $this->expectException(\TypeError::class);
//         $restaurant = new Restaurant();
//         $restaurant->setDescription(10);
//     }
// }