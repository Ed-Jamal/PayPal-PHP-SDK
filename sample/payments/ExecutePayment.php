<?php

require __DIR__ . '/../bootstrap.php';
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $paymentId = $_GET['paymentId'];
    $payment = Payment::get($paymentId, $apiContext);
    
    
    
    
    
    $execution = new PaymentExecution();
    $execution->setPayerId($_GET['PayerID']);
    $transaction = new Transaction();
    $amount = new Amount();
    $details = new Details();

    $details->setShipping(2.2)
        ->setTax(1.3)
        ->setSubtotal(17.50);

    $amount->setCurrency('USD');
    $amount->setTotal(21);
    $amount->setDetails($details);
    $transaction->setAmount($amount);
    
    
    
    
    
    
    
    
    
    
    
    
    
    $execution->addTransaction($transaction);
    
    try {
        $result = $payment->execute($execution, $apiContext);
        ResultPrinter::printResult("Executed Payment", "Payment", $payment->getId(), $execution, $result);
        try {
            $payment = Payment::get($paymentId, $apiContext);
        } catch (Exception $ex) {
            ResultPrinter::printError("Get Payment", "Payment", null, null, $ex);
            exit(1);
        }
    } catch (Exception $ex) {
        ResultPrinter::printError("Executed Payment", "Payment", null, null, $ex);
        exit(1);
    }
    
    ResultPrinter::printResult("Get Payment", "Payment", $payment->getId(), null, $payment);
    return $payment;
} else {
    ResultPrinter::printResult("User Cancelled the Approval", null);
    exit;
}
