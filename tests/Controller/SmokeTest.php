<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
    // public function testApiDocUrlIsSuccessful(): void
    // {
    //     $client = self::createClient();
    //     $client->followRedirects(false);
    //     $client->request("GET", "/api/doc");

    //     self::assertResponseIsSuccessful();
    // }

    // public function testApiAccountUrlIsSecure(): void
    // {
    //     $client = self::createClient();
    //     $client->followRedirects(false);
    //     $client->request("GET", "/api/account/me");
    //     // $client->request("GET", "/api/account/edit");

    //     self::assertResponseStatusCodeSame(401);
    // }

    public function testLoginRouteCanConnectAValidUser(): void
    {
        $client = self::createClient();
        $client->followRedirects(false);

        // $client->request('POST', '/api/registration', [], [], [
        //     'Content-Type' => 'application/json',
        // ], json_encode([
        //     "email" => "toto@mail.com",
        //     "password" => "toto",
        //     "firstname" => "Fath",
        //     "lastname" => "Dinga",
        //     "guestNumber" => 20,
        //     "allergy" => "cacahuètes"
        // ], JSON_THROW_ON_ERROR));

        $client->request('POST', '/api/login', [], [], [
            'CONTENT_TYPE' => 'application/json',

        ], json_encode([
            "username" => "toto@email.com",
            "password" => "toto",
        ], JSON_THROW_ON_ERROR));

        $statusCode = $client->getResponse()->getStatusCode();
        dd($statusCode);
    }

    public function testLoginRouteCanConnectAValidBooking(): void
    {
        $client = self::createClient();
        $client->followRedirects(false);

        $client->request('POST', '/api/booking', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            "guestNumber" => 5,
            "orderDate" => "2024-04-17",
            "orderHour" => "2024-04-17 16:30",
            "allergy" => "Cacahuètes"
        ], JSON_THROW_ON_ERROR));

        $statusCode = $client->getResponse()->getStatusCode();
        dd($statusCode);
    }

    public function testLoginRouteCanConnectAValidCategory(): void
    {
        $client = self::createClient();
        $client->followRedirects(false);

        $client->request('POST', '/api/category', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            "title" => "Titre du category",
        ], JSON_THROW_ON_ERROR));

        $statusCode = $client->getResponse()->getStatusCode();
        dd($statusCode);
    }
}