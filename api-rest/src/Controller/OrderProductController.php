<?php

namespace App\Controller;

use App\Aggregate\OrderProduct\OrderProductAggregate;
use App\Aggregate\OrderProduct\OrderProductEntities;
use App\Aggregate\OrderProduct\OrderProductRepositories;
use App\Entity\Order;
use App\Entity\Product;
use App\Exception\NotFoundException;
use App\Repository\Transactions\Transactional;
use App\Response\JsonMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * Class OrderProductController
 */
class OrderProductController extends AbstractController
{
    /**
     * @var OrderProductRepositories
     */
    private $orderProductRepositories;
    /**
     * @var Transactional
     */
    private $transactional;
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * OrderProductController constructor.
     *
     * @param OrderProductRepositories $orderProductRepositories
     * @param Transactional            $transactional
     * @param Serializer               $serializer
     */
    public function __construct(
        OrderProductRepositories $orderProductRepositories,
        Transactional $transactional,
        Serializer $serializer
    ) {
        $this->orderProductRepositories = $orderProductRepositories;
        $this->transactional = $transactional;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/order/{orderId}/product/{productId}", name="postOrderProduct", methods={ "POST" },
     *     requirements={"orderId"="\d+","productId"="\d+"})
     *
     * @ParamConverter("order", options={"mapping"={"orderId"="id"}})
     * @ParamConverter("product", options={"mapping"={"productId"="id"}})
     *
     * @param Order   $order
     * @param Product $product
     *
     * @return JsonResponse
     */
    public function postOrderProduct(Order $order = null, Product $product = null): JsonResponse
    {
        if (null === $order || null === $product) {
            throw new NotFoundException();
        }

        $entities = new OrderProductEntities($order, $product);
        $aggregate = new OrderProductAggregate($entities, $this->orderProductRepositories);
        $data = $this->transactional->run($aggregate);

        return JsonMessage::response(Response::HTTP_OK, $this->serializer->normalize($data));
    }
}
