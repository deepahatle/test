<?php

namespace VT\UsersBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserViewControllerTest extends WebTestCase
{
    public function testUserreportviewrender()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'reports');
    }

    public function testUsertrackingchartrender()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'tracking-chart');
    }

}
