<?php

namespace App\Payment;


interface PaymentProcessorInterface
{
    public function process();

    /**
     * @return bool
     */
    public function isProcessedSuccessfully();
}
