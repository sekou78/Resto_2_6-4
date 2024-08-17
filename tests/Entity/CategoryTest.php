<?php

// namespace App\Entity;

// use PHPUnit\Framework\TestCase;

// class CategoryTest extends TestCase
// {
//     public function provideTestUuid(): \Generator
//     {
//         yield ["230"];
//         yield ["500"];
//     }
//     /** @dataProvider provideTestUuid */
//     public function testUuid(string $description): void
//     {
//         $category = new Category;
//         $category->setUuid($description);
//         $this->assertSame($description, $category->getUuid());
//     }


//     public function provideTitle(): \Generator
//     {
//         yield ['The Best'];
//         yield ['Le Cornu'];
//     }
//     /** @dataProvider provideTitle */
//     public function testTitle(string $title): void
//     {
//         $category = new Category;
//         $category->setTitle($title);
//         $this->assertSame($title, $category->getTitle());
//     }

// }