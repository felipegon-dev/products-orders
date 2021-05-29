<?php

namespace App\Controller;

use App\DTO\OrderProductDTO;
use App\Entity\Order;
use App\Exception\NotFoundException;
use App\Repository\Contracts\OrderRepositoryInterface;
use App\Repository\OrderProductRepository;
use App\Request\JsonRequest;
use App\Response\JsonMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * Class OrderController
 */
class OrderController extends AbstractController
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var OrderProductRepository
     */
    private $orderProductRepo;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * OrderController constructor.
     *
     * @param OrderRepositoryInterface $orderRepository
     * @param OrderProductRepository   $orderProductRepo
     * @param Serializer               $serializer
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderProductRepository $orderProductRepo,
        Serializer $serializer
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderProductRepo = $orderProductRepo;
        $this->serializer = $serializer;
    }


    /**
     * @Route("/order", name="postOrder", methods={ "POST" })
     *
     * @param JsonRequest $request
     *
     * @return JsonResponse
     */
    public function postOrder(): JsonResponse
    {
        $order = $this->orderRepository->save();

        return JsonMessage::response(Response::HTTP_OK, $this->serializer->normalize($order));
    }

    /**
     * @Route("/order/{orderId}", name="getOrder", methods={ "GET" })
     *
     * @ParamConverter("order", options={"mapping"={"orderId"="id"}})
     *
     * @return JsonResponse
     */
    public function getOrder(Order $order = null): JsonResponse
    {
        if (null === $order) {
            throw new NotFoundException();
        }

        $orderProductDTO = new OrderProductDTO($order, $this->orderProductRepo->getProductsQuantity($order));

        return JsonMessage::response(Response::HTTP_OK, $this->serializer->normalize($orderProductDTO));
    }
}
