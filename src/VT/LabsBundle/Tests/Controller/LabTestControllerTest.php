<?php

namespace VT\LabsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LabTestControllerTest extends WebTestCase
{
    public function testLabtestrender()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'tests');
    }

}
