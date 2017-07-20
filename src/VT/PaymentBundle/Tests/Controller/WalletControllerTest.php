<?php

namespace VT\PaymentBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WalletControllerTest extends WebTestCase
{
    public function testRenderwallet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/wallet');
    }

}
