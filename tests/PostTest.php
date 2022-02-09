<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/post');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-type', 'application/json');

        $response = $client->getResponse();
        $responseData = json_decode($response->getContent());
        $this->assertIsArray($responseData);
        $this->assertCount(5, $responseData);
    }
}
