<?php
namespace App\Payment;

class MockedPaymentProcessor implements PaymentProcessorInterface{

    public function process()
    {
        // TODO: Implement process() method.
    }

    /**
     * @return bool
     */
    public function isProcessedSuccessfully()
    {
        // TODO: Implement isProcessedSuccessfully() method.

        return true;
    }
}
