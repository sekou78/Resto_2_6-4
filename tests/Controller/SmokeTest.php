<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
    public function testApiDocUrlIsSuccessful(): void
    {
        $client = self::createClient();
        $client->followRedirects(false);
        $client->request("GET", "/api/doc");

        self::assertResponseIsSuccessful();
    }

    public function testApiAccountUrlIsSecure(): void
    {
        $client = self::createClient();
        $client->followRedirects(false);
        $client->request("GET", "/api/account/me");
        // $client->request("GET", "/api/account/edit");

        self::assertResponseStatusCodeSame(401);
    }

    public function testLoginRouteCanConnectValidUser(): void
    {
        $client = self::createClient();
        // $client->followRedirects(false);

        // $client->request('POST', '/api/registration', [], [], [
        //     'Content-Type' => 'application/json',
        // ], json_encode([
        //     "email" => "adresse@mail.com",
        //     "password" => "mot de passe",
        //     "firstname" => "Fath",
        //     "lastname" => "Dinga",
        //     "guestNumber" => 20,
        //     "allergy" => "cacahuètes"
        // ], JSON_THROW_ON_ERROR));

        $client->request('POST', '/api/login', [], [], [
            'CONTENT_TYPE' => 'application/json',

        ], json_encode([
            "username" => "adresse@email.com",
            "password" => "Mot de passe",
        ], JSON_THROW_ON_ERROR));

        $statusCode = $client->getResponse()->getStatusCode();
        dd($statusCode);
    }
}