<?php

namespace VT\GeneralBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GeneralControllerTest extends WebTestCase
{
    public function testGeneralrender()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/generalRender');
    }

}
