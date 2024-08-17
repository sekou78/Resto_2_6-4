<?php

// namespace App\Entity;

// use DateTime;
// use DateTimeInterface;
// use PHPUnit\Framework\TestCase;

// class BookingTest extends TestCase
// {
//     public function provideTestUuid(): \Generator
//     {
//         yield ["230"];
//         yield ["500"];
//     }
//     /** @dataProvider provideTestUuid */
//     public function testUuid(string $uuid): void
//     {
//         $booking = new Booking;
//         $booking->setUuid($uuid);
//         $this->assertSame($uuid, $booking->getUuid());
//     }


//     public function provideGuestNumber(): \Generator
//     {
//         yield [60];
//         yield [10];
//     }
//     /** @dataProvider provideGuestNumber */
//     public function testGuestNumber(int $number): void
//     {
//         $booking = new Booking;
//         $booking->setGuestNumber($number);
//         $this->assertSame($number, $booking->getGuestNumber());
//     }


//     public function provideTestOrderDate(): \Generator
//     {
//         yield [new DateTime("29-05-2025")];
//         yield [new DateTime("2024-06-30")];
//     }
//     /** @dataProvider provideTestOrderDate */
//     public function testOrderDate(DateTimeInterface $date): void
//     {
//         $booking = new Booking;
//         $booking->setOrderDate($date);
//         $this->assertSame($date, $booking->getOrderDate());
//     }

//     public function provideTestOrderHour(): \Generator
//     {
//         yield [new DateTime("07:30")];
//         yield [new DateTime("21:20")];
//     }
//     /** @dataProvider provideTestOrderHour */
//     public function testOrderHour(DateTimeInterface $hour): void
//     {
//         $booking = new Booking;
//         $booking->setOrderHour($hour);
//         $this->assertSame($hour, $booking->getOrderHour());
//     }

//     public function provideTestAllergy(): \Generator
//     {
//         yield ["cacahuètes"];
//         yield ["Olives vert"];
//     }
//     /** @dataProvider provideTestAllergy */
//     public function testAllergy(string $allergy): void
//     {
//         $booking = new Booking;
//         $booking->setAllergy($allergy);
//         $this->assertSame($allergy, $booking->getAllergy());
//     }
// }


// namespace App\Tests\Entity;
 
// use App\Entity\Booking;
// use DateTime;
// use PHPUnit\Framework\TestCase;
 
// class BookingTest extends TestCase
// {
//    public function testOfBooking()
//    {
//         $testb = new Booking;
 
//         $testb->setGuestNumber('20');
//         $testb->setOrderDate(new DateTime('25-05-2019'));
//         $testb->setOrderHour(new DateTime("18:20"));
//         $testb->setAllergy('cacahuetes');
 
//         $this->assertEquals('20', $testb->getGuestNumber());
//         $this->assertEquals(new DateTime('25-05-2019'), $testb->getOrderDate());
//         $this->assertEquals(new DateTime("18:20"), $testb->getOrderHour());
//         $this->assertEquals('cacahuetes', $testb->getAllergy());
//    }
 
//    public function testIdBookingBigger0()
//    {
//         $testb = new Booking;
//         $testb->setAllergy('Olive');
//         $this->assertGreaterThanOrEqual('Olive', $testb->getAllergy());
//    }
// }