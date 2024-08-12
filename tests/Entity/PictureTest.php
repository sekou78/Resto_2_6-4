<?php 

namespace app\Tests\Entity;

use App\Entity\Picture;
use PHPUnit\Framework\TestCase;

class PictureTest extends TestCase
{
    public function provideFirstName(): \Generator
    {
        yield ['The Best slug'];
    }
    /** @dataProvider provideFirstName */
    public function testFirstNameSetter(string $name): void
    {
        $picture = new Picture;
        $picture->setTitle($name);
        $this->assertSame($name, $picture->getTitle());
    }
}