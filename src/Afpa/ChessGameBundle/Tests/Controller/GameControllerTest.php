<?php

namespace Afpa\ChessGameBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/home');
    }

    public function testCredits()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/credits');
    }

    public function testRules()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/rules');
    }

    public function testEnd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/end');
    }

}
