<?php

namespace VT\LabsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DashboardControllerTest extends WebTestCase
{
    public function testDashboardrender()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/dashboardRender');
    }

}
