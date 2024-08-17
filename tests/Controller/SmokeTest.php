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
        
        // $client->request('POST', '/api/login');
        
        // $client->request("POST", "/api/registration", [], [], [
        //     "Content-type" => "application/json",
        // ], json_encode([
        //     "firstname" => "lala",
        //     "lastname" => "lala",
        //     "email" => "lala@lala.fr",
        //     "password" => "lala",
        // ], JSON_THROW_ON_ERROR));

        $client->request('POST', '/api/login', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'username' => 'lala@lala.fr',
            'password' => 'lala',
        ], JSON_THROW_ON_ERROR));

        $statusCode = $client->getResponse()->getStatusCode();
        dd($statusCode);
    //     $this->assertEquals(401, $statusCode);
    //     // $this->assertEquals(200, $statusCode);
    //     $content = $client->getResponse()->getContent();
    //     $this->assertStringContainsString('user', $content);
    //     dd($content);
    }
}