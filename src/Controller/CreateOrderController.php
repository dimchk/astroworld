<?php


namespace App\Controller;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Order;
use App\Entity\Service;
use App\Payment\PaymentProcessorInterface;
use App\GoogleSpreadsheet\GoogleSpreadsheetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreateOrderController
 * @package App\Controller
 */
class CreateOrderController extends AbstractController
{
    /**
     * @Route("/api/orders", methods={"POST"})
     * @param Request $request
     * @param PaymentProcessorInterface $payments
     * @return Response
     */
    public function createOrder(Request $request, PaymentProcessorInterface $payments, ValidatorInterface $validator)
    {
        try {
            //Payment processing
            $payments->process();
            if ($payments->isProcessedSuccessfully()) {
                $entityManager = $this->getDoctrine()->getManager();
                $service = $entityManager->getRepository(Service::class)->find($request->query->get('serviceId'));

                if (!$service) {
                    throw $this->createNotFoundException(
                        'No Service found for id '
                    );
                }

                $order = new Order();
                $order->setService($service);
                $order->setClientEmail($request->query->get('clientEmail'));
                $order->setClientName($request->query->get('clientName'));

                $errors = $validator->validate($order);

                $entityManager->persist($order);
                $entityManager->flush();
            } else {
                return new Response('Problem with payments ', 400);
            }

            $google = new GoogleSpreadsheetService();
            $google->createNewOrderRow($order);
            return new Response('Saved new order with id ' . $order->getId());
        } catch (\Error $exception) {
            return new Response('Invalid request', 400);
        }

    }

    /**
     * @Route("/api/test")
     */
    public function testAction()
    {
        $google = new GoogleSpreadsheetService();
        $google->createNewOrderRow();
    }


}
