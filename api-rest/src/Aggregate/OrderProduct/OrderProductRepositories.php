<?php

namespace App\Aggregate\OrderProduct;

use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;

/**
 * Class OrderProductRepositories
 */
class OrderProductRepositories
{
    /**
     * @var OrderProductRepository
     */
    private $orderProductRepo;
    /**
     * @var OrderRepository
     */
    private $orderRepo;

    /**
     * OrderProductRepositories constructor.
     *
     * @param OrderProductRepository $orderProductRepo
     * @param OrderRepository        $orderRepo
     */
    public function __construct(OrderProductRepository $orderProductRepo, OrderRepository $orderRepo)
    {
        $this->orderProductRepo = $orderProductRepo;
        $this->orderRepo = $orderRepo;
    }

    /**
     * @return OrderProductRepository
     */
    public function getOrderProductRepo(): OrderProductRepository
    {
        return $this->orderProductRepo;
    }

    /**
     * @return OrderRepository
     */
    public function getOrderRepo(): OrderRepository
    {
        return $this->orderRepo;
    }
}
