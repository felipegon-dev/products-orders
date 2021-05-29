<?php

namespace App\Controller;

use App\Exception\AlreadyExistsException;
use App\Repository\Contracts\ProductRepositoryInterface;
use App\Request\JsonRequest;
use App\Response\JsonMessage;
use App\ValueObject\Name;
use App\ValueObject\Price;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * Class ProductController
 */
class ProductController extends AbstractController
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * ProductController constructor.
     *
     * @param ProductRepositoryInterface $productRepo
     * @param Serializer                 $serializer
     */
    public function __construct(ProductRepositoryInterface $productRepo, Serializer $serializer)
    {
        $this->productRepo = $productRepo;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/product", name="postProduct", methods={ "POST" })
     *
     * @param JsonRequest $request
     *
     * @return JsonResponse
     */
    public function postProduct(JsonRequest $request): JsonResponse
    {
        $name = Name::create($request->getParam('name'));
        $price = Price::create($request->getParam('price'));

        if ($this->productRepo->has($name)) {
            throw new AlreadyExistsException();
        }

        $product = $this->productRepo->save($name, $price);

        return JsonMessage::response(Response::HTTP_OK, $this->serializer->normalize($product));
    }
}
