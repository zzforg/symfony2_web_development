<?php
namespace Ibase\PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IbasePaymentController extends Controller
{
    /**
     * This controller is not using, for further dev
     * @return type
     */
    public function preparePaypalAction()
    {
//        $orderId = $this->forward('IbaseCartBundle:Cart:placeOrder');
        //        $form = $this->createPurchaseForm();
//        $form->handleRequest($request);
//        if ($form->isValid()) {
//            $data = $form->getData();
        $paymentName = 'Ibase_paypal_express';
        $storage = $this->get('payum')->getStorage('Ibase\PaymentBundle\Entity\PaymentDetails');

        /** @var \Ibase\CartBundle\Entity\PaymentDetails $paymentDetails */
        $paymentDetails = $storage->createModel();
        $paymentDetails['PAYMENTREQUEST_0_CURRENCYCODE'] = 'AUD';
        $paymentDetails['PAYMENTREQUEST_0_AMT'] = 190;//total amount ??
        //for loop iterate products
        $paymentDetails['L_PAYMENTREQUEST_0_AMT0'] = 20;
        $paymentDetails['L_PAYMENTREQUEST_0_QTY0'] = 2;
        $paymentDetails['L_PAYMENTREQUEST_0_NAME0'] = 'item1';
        $paymentDetails['L_PAYMENTREQUEST_0_DESC0'] = 'this is item1';

        $paymentDetails['L_PAYMENTREQUEST_0_AMT1'] = 50;
        $paymentDetails['L_PAYMENTREQUEST_0_QTY1'] = 3;
        $paymentDetails['L_PAYMENTREQUEST_0_NAME1'] = 'item2';
        $paymentDetails['L_PAYMENTREQUEST_0_DESC1'] = 'this is item2';

        $storage->updateModel($paymentDetails);

        $captureToken = $this->get('payum.security.token_factory')->createCaptureToken(
            $paymentName,
            $paymentDetails,
            'ibase_payment_done' // the route to redirect after capture;
        );
        $paymentDetails['INVNUM'] = $paymentDetails->getId();
        $paymentDetails['RETURNURL'] = $captureToken->getTargetUrl();
        $paymentDetails['CANCELURL'] = $captureToken->getTargetUrl();
        $storage->updateModel($paymentDetails);

        return $this->redirect($captureToken->getTargetUrl());
    }
}

