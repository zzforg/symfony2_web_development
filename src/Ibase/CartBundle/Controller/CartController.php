<?php
namespace Ibase\CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Ibase\StoreBundle\Entity\Purchase;
use Ibase\StoreBundle\Entity\PurchasePerItem;
use Ibase\PaymentBundle\Entity\PaymentDetails;

class CartController extends Controller
{
    /**
     * The main action of shopping cart, to display the products user chosen.
     * @Route("/listCart")
     * @Template()
     * 1. check if there were any products added in the cart
     * 2. list the products to user
     */
    public function listCartAction()
    {
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        
        //Shopping cart
        $cart = $session->get('cart', array());
        foreach($cart as $id => $num){
            $product[] = $em->getRepository('IbaseStoreBundle:Product')
                            ->find($id);
        }
        
        if($cart != ''){
            //get products from orm and session
            if(isset($product)){
                return $this->render('IbaseCartBundle:Cart:listCart.html.twig', 
                    array(    
                        'empty' => false,
                        'product' => $product,
                ));
            } else{
                return $this->render('IbaseCartBundle:Cart:listCart.html.twig', 
                    array(    
                        'empty' => true,
                        'product' => false,
                ));
            }
        } else {
            $this->get('logger')->info('there is not product in the cart');
            return $this->render('IbaseCartBundle:Cart:listCart.html.twig', 
                array(    
                    'empty' => true,
                    'product' => false,
            ));
        }
    }

    /**
     * 1. check if the product already exist in the cart
     * 2. check if it has the avaliable quantities
     * 3. add the product into the cart
     * 4. save as session
     * @Route("/addToCart")
     * @Template()
     */
    public function addToCartAction($id, $num)
    {
        $session = $this->getRequest()->getSession();
        $cart = $session->get('cart', array());
        //fetch the cart
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('IbaseStoreBundle:Product')->find($id);

        if($product == NULL || $num < 1){         
            return $this->render('IbaseCartBundle:Cart:addToCart.html.twig', array(
                'order' => false, 
            ));
        } else {
            if(isset($cart[$id])){
                //Check the num in stock
//                $numInStock = $product->getQuantity();
//                $stockMax = $cart[$id] + 1;
//                if($numInStock >= $stockMax){
                    $cart[$id] = $num;
//                } else {
//                    return $this->render('IbaseCartBundle:Cart:addToCart.html.twig', array(
//                        'order' => false, 
//                    ));
////                    //not enough in stock          
////                    return $this->redirect($this->generateUrl('listCart'));
//                }
//            } else {
                
                //Store into session
                $session->set('cart', $cart);
                $this->totalWithoutFreight();
                return $this->render('IbaseCartBundle:Cart:addToCart.html.twig', array(
                    'order' => true,
                ));
            } else {
                //if it doesnt make it 1
                $cart[$id] = $num;
                $session->set('cart', $cart);
                $this->totalWithoutFreight();
                return $this->render('IbaseCartBundle:Cart:addToCart.html.twig', array(
                    'order' => true,
                ));
            }
            
        } 
    }
    
    /**
     * This action displays users details and allow them to choose payment methods.
     * @Route("/ibase_payment")
     * @Template("payment.html.twig")
     */
    public function paymentAction()
    {
        $session = $this->getRequest()->getSession();
        //check if a customer has been created or redirect to homepage
        if(!$session->has('cart') || !$session->has('customer')){
            return $this->redirect($this->generateUrl('ibase_home')); 
        }
        $customerSession = $session->get('customer');
        $cart = $session->get('cart', array());
        $em = $this->getDoctrine()->getManager();
        $customer[] = $em->getRepository('IbaseStoreBundle:Customer')
                            ->find($customerSession);
        //products
        foreach($cart as $id => $num){
            $products[] = $em->getRepository('IbaseStoreBundle:Product')
                    ->find($id);
        }
        
        if(isset($customer)&&isset($products)){
            foreach($products as $p){
                if($p->getFreight() == null){
                    return $this->render("IbaseCartBundle:Cart:payment.html.twig", 
                    array(
                        'hasCustomer' => true,
                        'customerDetails' => $customer,
                        'freight' => true
                    ));
                } else {
                    return $this->render("IbaseCartBundle:Cart:payment.html.twig", 
                    array(
                        'hasCustomer' => true,
                        'customerDetails' => $customer,
                        'freight' => false
                    ));
                }
            }
        }
        return $this->render("IbaseCartBundle:Cart:payment.html.twig", 
                        array(
                            'hasCustomer' => false,
                        ));
    }
    
    /**
     * General place order function for all payment methods
     * email admin after order placed
     * @return \Ibase\StoreBundle\Entity\Purchase
     */
    public function placeOrder(){
        //If no purchase redirect to home
        $session = $this->getRequest()->getSession();
        if(!$session->has('cart') || !$session->has('customer')){
            return $this->redirect($this->generateUrl('ibase_home')); 
        }
        //email to admin
        $emailType = 6; 
        $adminEmail = $this->container->getParameter('mailer_user');

        //New order instance
        $purchase = new Purchase();
        $totalAmount = 0;
        
        //retrieve data
        $em = $this->getDoctrine()->getManager();
        $cart = $session->get('cart', array());
        $customerSession = $session->get('customer');
        
        //set customer to order
        if($customerSession != ''){
            $customer = $em
                ->getRepository('IbaseStoreBundle:Customer')
                ->find($customerSession);
            if(isset($customer)){
                $purchase->setCustomer($customer); 
            }
        }
        
        //pass products into order
        if($cart != ''){
            $purchase->setStatus("proccessing");
            $purchase->setDeliveryFee("0");
            foreach($cart as $id => $num){
                $product = $em->getRepository('IbaseStoreBundle:Product')
                                ->find($id);
                //PurchasePerItem instance (each product)
                $purchasePerItem = new PurchasePerItem();
                $purchasePerItem->setPurchase($purchase);
                $purchasePerItem->setProduct($product);
                $purchasePerItem->setQuantity($num);
                $em->persist($purchasePerItem);
                $purchase->addPurchasePerItem($purchasePerItem);
                $itemTotal = $product->getPrice() * $num;
                $totalAmount += $itemTotal;
                $purchase->setTotalAmount($totalAmount);
                
                //check if any product's delivery fee has set, 
                $shipping = $product->getFreight();
                if(!isset($shipping)){
                    $purchase->setDeliveryFee(null);
                }
                $em->persist($purchase); 
            }
            //flush into db
            $em->flush();
            //Email to admin email notice new order
                $this->sendEmail($adminEmail, $emailType, $purchase);
        }else {
            //check if any products? yes : go home page
            return $this->redirect($this->generateUrl('ibase_home')); 
        }
        return $purchase;
    }
    
    /**
     * @Route("/ibase_pickUp")
     * @Template("pickUp.html.twig")
     * @return render pickUp.html.twig
     */
    public function pickUpAction(){
        $emailType = 4;
        $em = $this->getDoctrine()->getManager();
        $purchase = $this->placeOrder();
        if(isset($purchase)){
            $purchase->setStatus("pickup");
            $em->persist($purchase);
            $em->flush();
            //Send email
            $this->sendEmail($purchase->getCustomer()->getEmail(), $emailType, $purchase);
            //Clear session after purchased
//                $session->clear();
            return $this->render("IbaseCartBundle:Cart:pickUp.html.twig", 
                array(
                    'success' => true,
                    'purchase' => $purchase,
                ));
        } else {
            //order fail, error page or home?
            return $this->redirect($this->generateUrl('ibase_home')); 
        }
        return $this->render("IbaseCartBundle:Cart:pickUp.html.twig", 
                array(
                    'success' => false,
                ));
    }
    
    /**
     * payment method: Bank transfer
     * 1. complete order
     * 2. if freight wait email
     * 3. if not freight, give order number as reference
     */
    public function bankDirectAction(){
        $emailType = 1;//need change for bank transfer?
        $em = $this->getDoctrine()->getManager();
        $purchase = $this->placeOrder();
        if(isset($purchase)){
            //change status
            //send email to customer
            //$this->sendEmail($purchase->getCustomer()->getEmail(), $emailType, $purchase);
            //Clear session after purchased
//                $session->clear();
            return $this->render("IbaseCartBundle:Cart:bank.html.twig", 
                array(
                    'success' => true,
                    'purchase' => $purchase,
                ));
        } else {
            //order fail, error page or home?
        }
        
    }
    
    /**
     * Payment method: Paypal with delivery fee request
     *  1. complete order
     *  2. set delivery fee
     *  3. send email
     *  4. complete payment
     * @return type
     */
    public function orderBeforePaypalAction(){
        //Check if there is any order then go to homepage
        $session = $this->getRequest()->getSession();
        //check if a customer has been created or redirect to homepage
        if(!$session->has('cart') || !$session->has('customer')){
            return $this->redirect($this->generateUrl('ibase_home')); 
        }
        //place order and request freight
        $em = $this->getDoctrine()->getManager();
        $emailType = 5; //5 is for feight request to Ibase admin
        $adminEmail = $this->container->getParameter('mailer_user');
        $purchase = $this->placeOrder();
        $shipping = $purchase->getDeliveryFee();
        if(!isset($shipping)){
            //checkout without free shipping
            $purchase->setStatus("freight");
            $em->persist($purchase);
            $em->flush();
            if(isset($purchase)){
                $customer = $purchase->getCustomer();
                $products =$purchase->getPurchasePerItem();
                foreach($products as $item){
                    $pro[] = $item->getProduct();
                    $qty[] = $item->getQuantity();
                }
                //sent email to admin to require add freight
                $this->sendEmail($adminEmail, $emailType, $purchase);
                return $this->render("IbaseCartBundle:Cart:placeOrder.html.twig", 
                        array(
                            'success' => true,
                            'customerDetails' => $customer,
                            'purchase' => $purchase,
                            'products' => $pro,
                            'qty' => $qty,
                        ));
            } else {
                return $this->render("IbaseCartBundle:Cart:placeOrder.html.twig", 
                        array(
                            'success' => false,
                        ));
            }
        } else {
            //checkout with free shipping
            return $this->preparePaypal($purchase);
        }
    }
    
    /**
     * This function allow users to return from email when admin has set up the
     * shipping and send the email.
     * @param type $orderNum
     * @return type
     */
    public function reorderAction($orderNum){
        $purchaseId = $orderNum - 100000;
        //get order
        $em = $this->getDoctrine()->getManager();
        $purchase = $em->getRepository('IbaseStoreBundle:Purchase')
                        ->find($purchaseId);
        $orderStatus = $purchase->getStatus();
        if(isset($purchase) && $orderStatus != 'pickup'){
            //set payment detials
            $paymentName = 'Ibase_paypal_express';
            //create paypal item details
            /** @var \Ibase\CartBundle\Entity\PaymentDetails $paymentDetails */
            $storage = $this->get('payum')
                    ->getStorage('Ibase\PaymentBundle\Entity\PaymentDetails');
            $paymentDetails = $storage->createModel();
            $total=0;
            $total += $purchase->getTotalAmount();
            $total += $purchase->getDeliveryFee();
            $paymentDetails['PAYMENTREQUEST_0_PAYMENTREQUESTID'] = $orderNum;
            $paymentDetails['PAYMENTREQUEST_0_CURRENCYCODE'] = 'AUD';
            $paymentDetails['PAYMENTREQUEST_0_AMT'] = $total;
            $paymentDetails['PAYMENTREQUEST_0_ITEMAMT'] = $purchase->getTotalAmount();
            //TBC
            $paymentDetails['PAYMENTREQUEST_0_SHIPPINGAMT'] = $purchase->getDeliveryFee();
            //for loop iterate products and store into $paymentDetails
            $p =$purchase->getPurchasePerItem();
            foreach($p as $a){
                $pro[] = $a->getProduct();
                $qty[] = $a->getQuantity();
            }
            //store payment items details
            
            for($k = 0; $k < count($pro); $k++){
                $itemAmt = 'L_PAYMENTREQUEST_0_AMT'.$k;
                $itemQty = 'L_PAYMENTREQUEST_0_QTY'.$k;
                $itemName = 'L_PAYMENTREQUEST_0_NAME'.$k;
                $itemModel= 'L_PAYMENTREQUEST_0_NUMBER'.$k;
//                $itemDes = 'L_PAYMENTREQUEST_0_DESC'.$k;
                $paymentDetails[$itemAmt] = $pro[$k]->getPrice();
                $paymentDetails[$itemQty] = $qty[$k];
                $paymentDetails[$itemName] = $pro[$k]->getName();
                $paymentDetails[$itemModel] = $pro[$k]->getModel();
//                $paymentDetails[$itemDes] = 'item description';
            }
            $storage->updateModel($paymentDetails);
            
            //Other method
            $captureToken = $this->get('payum.security.token_factory')
                    ->createCaptureToken(
                $paymentName,
                $paymentDetails,
                'ibase_payment_done' // the route to redirect after capture;
            );
            $paymentDetails['INVNUM'] = $paymentDetails->getId();
            $paymentDetails['RETURNURL'] = $captureToken->getTargetUrl();
            $paymentDetails['CANCELURL'] = $captureToken->getTargetUrl();
            $storage->updateModel($paymentDetails);
            
            return $this->render("IbaseCartBundle:Cart:reorder.html.twig", 
                array(
                    'success' => true,
                    'purchase' => $purchase,
                    'customerDetails' => $purchase->getCustomer(),
                    'products' => $pro,
                    'qty' => $qty,
                    'url' => $captureToken->getTargetUrl(),
                ));
        } else {
            return $this->redirect($this->generateUrl('ibase_home'));
        }
    }
    
    /**
     * Payment method: Paypay with no delivery fee
     * Go to paypal directly
     * 
     * @return type
     */
    public function preparePaypal(Purchase $purchase){
        $paymentName = 'Ibase_paypal_express';
        //create paypal item details
        /** @var \Ibase\CartBundle\Entity\PaymentDetails $paymentDetails */
        $storage = $this->get('payum')->getStorage('Ibase\PaymentBundle\Entity\PaymentDetails');
        $paymentDetails = $storage->createModel();
        $orderStatus = $purchase->getStatus();
        if(isset($purchase) && $orderStatus != 'pickup'){
            //set payment detials
            $paymentName = 'Ibase_paypal_express';
            $orderNum = $purchase->getId() + 100000;
            //create paypal item details
            /** @var \Ibase\CartBundle\Entity\PaymentDetails $paymentDetails */
            $storage = $this->get('payum')
                    ->getStorage('Ibase\PaymentBundle\Entity\PaymentDetails');
            $paymentDetails = $storage->createModel();
            $total=0;
            $total += $purchase->getTotalAmount();
            $total += $purchase->getDeliveryFee();
            $paymentDetails['PAYMENTREQUEST_0_PAYMENTREQUESTID'] = $orderNum;
            $paymentDetails['PAYMENTREQUEST_0_CURRENCYCODE'] = 'AUD';
            $paymentDetails['PAYMENTREQUEST_0_AMT'] = $total;
            $paymentDetails['PAYMENTREQUEST_0_ITEMAMT'] = $purchase->getTotalAmount();
            //TBC
            $paymentDetails['PAYMENTREQUEST_0_SHIPPINGAMT'] = $purchase->getDeliveryFee();
            //for loop iterate products and store into $paymentDetails
            $p =$purchase->getPurchasePerItem();
            foreach($p as $a){
                $pro[] = $a->getProduct();
                $qty[] = $a->getQuantity();
            }
            //store payment items details
            for($k = 0; $k < count($pro); $k++){
                $itemAmt = 'L_PAYMENTREQUEST_0_AMT'.$k;
                $itemQty = 'L_PAYMENTREQUEST_0_QTY'.$k;
                $itemName = 'L_PAYMENTREQUEST_0_NAME'.$k;
                $itemModel= 'L_PAYMENTREQUEST_0_NUMBER'.$k;
//                $itemDes = 'L_PAYMENTREQUEST_0_DESC'.$k;
                $paymentDetails[$itemAmt] = $pro[$k]->getPrice();
                $paymentDetails[$itemQty] = $qty[$k];
                $paymentDetails[$itemName] = $pro[$k]->getName();
                $paymentDetails[$itemModel] = $pro[$k]->getModel();
//                $paymentDetails[$itemDes] = 'item description';
            }
            $storage->updateModel($paymentDetails);
            
            $captureToken = $this->get('payum.security.token_factory')
                    ->createCaptureToken(
                $paymentName,
                $paymentDetails,
                'ibase_payment_done' // the route to redirect after capture;
            );
            $paymentDetails['INVNUM'] = $paymentDetails->getId();
            $paymentDetails['RETURNURL'] = $captureToken->getTargetUrl();
            $paymentDetails['CANCELURL'] = $captureToken->getTargetUrl();
            $storage->updateModel($paymentDetails);
        //Clear session after purchased
        //$session->clear();
            return $this->redirect($captureToken->getTargetUrl());
        } else {
            //No order then go back homepage
            return $this->redirect($this->generateUrl('ibase_home'));
        }
        return $this->redirect($this->generateUrl('ibase_home'));
    }
    
    /**
     * @Template("renderCart.html.twig")
     * @return render renderCart.html.twig
     */
    public function renderCartAction(){
        $session = $this->getRequest()->getSession();
        $cart = $session->get('cart', array());
        
        $em = $this->getDoctrine()->getManager();
        foreach($cart as $id => $num){
            $product[] = $em->getRepository('IbaseStoreBundle:Product')
                            ->find($id);
        }
        
        if($cart != ''){
            //get products from orm and session
            if(isset($product)){
                return $this->render('IbaseCartBundle:Cart:renderCart.html.twig', 
                    array(    
                        'empty' => false,
                        'product' => $product,
                ));
            } else{
                return $this->render('IbaseCartBundle:Cart:renderCart.html.twig', 
                    array(    
                        'empty' => true,
                        'product' => false,
                ));
            }
        } else {
            return $this->render('IbaseCartBundle:Cart:renderCart.html.twig', 
                array(    
                    'empty' => true,
                    'product' => false,
            ));
        }
    }
    
    /**                  
     * This controller handles the sub total and final total price of products
     * in the shopping cart using Ajax                                                                 
     * @Route("/numAjax")
     */
   public function numAjaxAction()    
   {
        $session = $this->getRequest()->getSession();
        $cart = $session->get('cart', array());
        //get request from input
        $request = $this->get('request');
        $num=$request->request->get('num');
        $id=$request->request->get('id');
       
        //get each product price
        $em = $this->getDoctrine()->getManager();
        $totalPrice = 0;
        if ($num > 0) {
            $cart[$id] = $num;
            $session->set('cart', $cart);
            //Total price
            $totalPrice = $this->totalWithoutFreight();
            $return = array("response"=>"success", "total" => $totalPrice);
        } else {
            $return =array("response" => "fail");
        }
        $return = json_encode($return);
        return new Response($return, 200, array(
            'Content-Type'=>'application/json'
            ));
    }
    
    /**
     * A function to calculation total amount with out delivery fee and store it
     * into session
     * @param type $id
     * @param type $num
     * @return $totalPrice
     */
    private function totalWithoutFreight(){
        $session = $this->getRequest()->getSession();
        $cart = $session->get('cart', array());
        $em = $this->getDoctrine()->getManager();
        $totalPrice = 0;
        if(isset($cart)){
            foreach($cart as $id => $num){
                $eachPrice[] = $em->getRepository('IbaseStoreBundle:Product')
                            ->find($id)
                            ->getPrice()*$num;
            }
            for($i=0; $i<sizeof($eachPrice); $i++){
                $totalPrice += $eachPrice[$i];
            }
            $session->set('Payment_Amount', $totalPrice);
            return $totalPrice;
        }
        return null;
    }
    
    /**
     * A private function to remove single product from session(Cart)
     * @param void $id
     * @throws createNotFoundException
     */
    private function removeProduct($id) {
        $session = $this->getRequest()->getSession();
        $cart = $session->get('cart', array());
        if(isset($cart[$id])){
            $cart[$id] = 0;
            unset($cart[$id]);
            // update shopping cart in session
            $session->set('cart', $cart);
        } else {
            // to be decided...
            throw $this->createNotFoundException('Cannot find this product.');
        }
    }
    
    /**
     * An AJAX to remove more than one product at a time
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function multiDelAjaxAction(){
        $session =$this->getRequest()->getSession();
        $cart = $session->get('cart', array());
        $request = $this->get('request');
        
        //get ids
        $pids=$request->request->get('ids');
        //remove all from session
        if(isset($pids)) {
            foreach ($pids as $id) {
               $this->removeProduct($id);
            }
            $this->totalWithoutFreight();
            $return =array("response" => "done");
        } else {
            $return =array("response" => "fail");
        }
        $return = json_encode($return);
        return new Response($return, 200, array(
            'Content-Type'=>'application/json'
            ));
    }
    
    /**
     * This method has been used in the cart(Remove item)
     * @Route("/removeFromCart")
     * @Template()
     */
    public function removeCartAction($id)
    {
        $session = $this->getRequest()->getSession();
        $cart = $session->get('cart', array());
        
        if($cart !='' || isset($cart[$id])){
            $cart[$id] = 0;
            unset($cart[$id]);
            $session->set('cart', $cart);
            $this->totalWithoutFreight();
            return $this->render('IbaseCartBundle:Cart:removeFromCart.html.twig',
                    array(    
                        'success' => true,
                    ));
        } else {
            return $this->render('IbaseCartBundle:Cart:removeFromCart.html.twig', 
                array(    
                    'success' => false,
                ));
        }
    }
    
    /**
     * @Route("/clearCart")
     * @Template()
     */
    public function clearCartAction()
    {
        $session = $this->getRequest()->getSession();
        $session->get('cart', array())->clear();
        return $this->render('IbaseCartBundle:Cart:clearCart.html.twig');
    }
    
    /**
     * Reusable function sendEmail
     * @param type $to
     * @param type $type
     * @param \Ibase\StoreBundle\Entity\Purchase $order
     */
    public function sendEmail($to, $type, Purchase $order){
        $this->forward('ibase.mail.controller:sendMail', 
            array(
                'to' => $to,
                'type' => $type,
                'order' => $order,
            ));
    }
    
    /**
     * @Route("/removeProduct/{pids}")
     * @Template()
     */
//    public function removeAction($pids) {
//        if(isset($pids) && $pids != " ") {
//            foreach ($pids as $product) {
//               $this->removeProduct($product);
//            }
//            return $this->render('IbaseCartBundle:Cart:removeFromCart.html.twig',
//                    array(
//                        'success' => true,
//                    ));
//        } else {
//            //throw $this->createNotFoundException('Please choose an item.');
//            // error that a specific item missing hasn't been handled!!!
//            return $this->render('IbaseCartBundle:Cart:removeFromCart.html.twig',
//                    array(    
//                        'success' => false,
//                    ));
//        }
//    }
//    

}
