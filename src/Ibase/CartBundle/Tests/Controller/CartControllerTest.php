<?php

namespace Ibase\CartBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    public function testListcart()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listCart');
    }

    public function testAaddtocart()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AaddToCart');
    }

    public function testRemovefromcart()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/removeFromCart');
    }

    public function testClearcart()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/clearCart');
    }

}
