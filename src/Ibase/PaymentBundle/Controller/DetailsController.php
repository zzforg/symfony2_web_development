<?php
namespace Ibase\PaymentBundle\Controller;

use Payum\Bundle\PayumBundle\Controller\PayumController;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\BinaryMaskStatusRequest;
use Payum\Core\Request\SyncRequest;
use Symfony\Component\HttpFoundation\Request;

class DetailsController extends PayumController
{
    public function doneAction(Request $request)
    {
        $log = $this->get('logger');
        $token = $this->get('payum.security.http_request_verifier')->verify($request);
        
        $payment = $this->get('payum')->getPayment($token->getPaymentName());

        try {
            $payment->execute(new SyncRequest($token));
        } catch (RequestNotSupportedException $e) {
            $log->error('Fail to get callback from paypal');
        }
        
        $status = new BinaryMaskStatusRequest($token);
        $payment->execute($status);
        
        //Change order status to "waiting ship"
        $statusDetails = $status->getModel();
        $purchaseId = $statusDetails['PAYMENTREQUEST_0_PAYMENTREQUESTID'];
        if(!isset($purchaseId)){
            $log->error('Could not get order number from paypal status');
        }
        $pid = $purchaseId - 100000;
        $em = $this->getDoctrine()->getManager();
        $purchase = $em->getRepository('IbaseStoreBundle:Purchase')
                        ->find($pid);
        if(isset($purchase)){
            $purchase->setStatus("paid");
            $em->persist($purchase);
            $em->flush();
        } else {
            $log->error('Could not find the order from the order id!');
        }

        return $this->render('IbasePaymentBundle:PaypalExpress:view.html.twig', array(
            'status' => $status,
            'paymentTitle' => ucwords(str_replace(array('_', '-'), ' ', $token->getPaymentName())),
            'order' => $purchase
        ));
    }
}