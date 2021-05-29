<?php

namespace App\Aggregate\OrderProduct;

use App\Entity\Order;
use App\Entity\Product;

/**
 * Class OrderProductAggregate
 */
class OrderProductEntities
{
    /**
     * @var Order
     */
    private $order;
    /**
     * @var Product
     */
    private $product;

    /**
     * OrderProductAggregate constructor.
     *
     * @param Order   $order
     * @param Product $product
     */
    public function __construct(Order $order, Product $product)
    {
        $this->order = $order;
        $this->product = $product;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }
}
