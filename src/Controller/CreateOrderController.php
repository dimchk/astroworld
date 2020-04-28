<?php


namespace App\Controller;

use App\Message\OrderMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\ConstraintViolation;
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
    public function createOrder(
        Request $request,
        PaymentProcessorInterface $payments,
        ValidatorInterface $validator,
        MessageBusInterface $bus
    ) {
        try {
            //Payment processing
            $payments->process();
            if ($payments->isProcessedSuccessfully()) {
                $entityManager = $this->getDoctrine()->getManager();
                $service = $entityManager->getRepository(Service::class)->find($request->query->get('serviceId'));

                if (!$service) {
                    return new JsonResponse("Service doesn't exist", 400);
                }

                $order = new Order();
                $order->setService($service);
                $order->setClientEmail($request->query->get('clientEmail'));
                $order->setClientName($request->query->get('clientName'));

                $errors = $validator->validate($order);
                if (count($errors) > 0) {
                    $messages = [];
                    /**
                     * @var ConstraintViolation $error
                     */
                    foreach ($errors as $error) {
                        $messages[] = ['Field' => $error->getPropertyPath(), 'Reason' => $error->getMessage()];
                    }

                    return new JsonResponse($messages, 400);

                }

                $entityManager->persist($order);
                $entityManager->flush();

                $bus->dispatch(new OrderMessage($order->getId()));

            } else {
                return new JsonResponse('Problem with payments ', 400);
            }


            return new JsonResponse('Saved new order with id ' . $order->getId());
        } catch (\Error $exception) {

            return new JsonResponse('Invalid request', 400);
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
