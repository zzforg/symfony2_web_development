<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ibase\PaymentBundle\Payum\Api;

use Payum\Paypal\ExpressCheckout\Nvp\Api;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of Factory
 *
 * @author zhiguo
 */
class Factory {
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return Api
     */
    public function createPaypalExpressCheckoutApi()
    {
        return new Api($this->container->get('payum.buzz.client'), array(
            'username' => $this->container->getParameter('paypal.express_checkout.username'),
            'password' => $this->container->getParameter('paypal.express_checkout.password'),
            'signature' => $this->container->getParameter('paypal.express_checkout.signature'),
            'sandbox' => true
        ));
    }
}
