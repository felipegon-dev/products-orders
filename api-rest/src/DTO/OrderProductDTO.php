<?php

namespace App\DTO;

use App\Entity\Order;
use App\Entity\OrderProduct;

/**
 * Class OrderProductDTO
 */
class OrderProductDTO
{
    /**
     * @var Order|null
     */
    private $order;

    /**
     * @var OrderProduct[]|null
     */
    private $products;

    /**
     * OrderProductDTO constructor.
     *
     * @param Order|null          $order
     * @param OrderProduct[]|null $products
     */
    public function __construct(?Order $order = null, ?array $products = null)
    {
        $this->order = $order;
        $this->products = $products;
    }

    /**
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * @return OrderProduct[]|null
     */
    public function getProducts(): ?array
    {
        return $this->products;
    }
}
