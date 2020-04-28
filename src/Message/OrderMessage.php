<?php

namespace App\Message;

class OrderMessage
{
    /*
     * @var int
     */
    private $orderId;

    public function __construct(int $order_id)
    {
        $this->orderId = $order_id;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId($orderId): void
    {
        $this->orderId = $orderId;
    }


}
