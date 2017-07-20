<?php

namespace VT\HomeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHomerender()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

}
