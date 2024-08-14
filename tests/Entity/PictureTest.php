<?php 

namespace app\Tests\Entity;

use App\Entity\Picture;
use PHPUnit\Framework\TestCase;

class PictureTest extends TestCase
{
    public function provideTestTiltePicture(): \Generator
    {
        yield ["Title Picture"];
    }
    /** @dataProvider provideTestTiltePicture */
    public function testPictureTitle(string $title): void
    {
        $picture = new Picture;
        $picture->setTitle($title);
        $this->assertSame($title, $picture->getTitle());
    }

    public function providePictureSlug(): \Generator
    {
        yield ["Title Picture"];
        yield ['The Best slug'];
    }
    /** @dataProvider providePictureSlug */

    public function testprovidePictureSlugGetter(string $slug): void
    {
        $picture = new Picture;
        $picture->setSlug($slug);
        $this->assertSame($slug, $picture->getSlug());
    }

    public function testAnException(): void
    {
        $this->expectException(\TypeError::class);
        $picture = new Picture();
        $picture->setSlug(10);
    }
}
