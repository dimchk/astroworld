<?php

namespace App\MessageHandler;
use App\Entity\Order;
use App\GoogleSpreadsheet\GoogleSpreadsheetService;
use App\Message\OrderMessage as OrderMessage;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class GoogleSpreadSheetHandler implements \Symfony\Component\Messenger\Handler\MessageHandlerInterface
{

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(OrderMessage $orderMessage)
    {
        /**
         *  @var $order Order
         */
        $order = $this->entityManager->getRepository(Order::class)->find($orderMessage->getOrderId());
        $google = new GoogleSpreadsheetService();
        $google->createNewOrderRow($order);

    }
}
