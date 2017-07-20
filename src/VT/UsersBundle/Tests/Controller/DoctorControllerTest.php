<?php

namespace VT\UsersBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DoctorControllerTest extends WebTestCase
{
    public function testDoctorrender()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'doctors');
    }

}
