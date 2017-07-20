<?php

namespace VT\UsersBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserVisitControllerTest extends WebTestCase
{
    public function testPatientrecordrender()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'patients-list');
    }

    public function testAddpatientrecordrender()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'add-patients');
    }

}
