<?php

namespace VT\LabsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LabProfileControllerTest extends WebTestCase
{
    public function testEditlabrender()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/edit-profile');
    }

}
