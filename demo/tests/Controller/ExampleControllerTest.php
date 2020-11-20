<?php
// https://symfony.com/doc/4.4/testing.html
namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExampleControllerTest extends WebTestCase
{
    public function testCalc()
    {
        $client = static::createClient();
        $client->request("GET", "/calc/5");
        $res = $client->getResponse();

        $this->assertEquals(200, $res->getStatusCode());
        $this->assertTrue($res->headers->contains("Content-Type", "application/json"));
    }
}