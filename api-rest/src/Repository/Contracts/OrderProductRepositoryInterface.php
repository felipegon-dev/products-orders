<?php

namespace App\Repository\Contracts;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;

/**
 * Interface OrderProductRepositoryInterface
 */
interface OrderProductRepositoryInterface
{
    /**
     * @param Product $product
     * @param Order   $order
     *
     * @return OrderProduct
     */
    public function save(Product $product, Order $order): OrderProduct;

    /**
     * @param Order $order
     *
     * @return array
     */
    public function getProductsQuantity(Order $order): array;

    /**
     * @param Order $order
     *
     * @return float
     */
    public function getSumPrice(Order $order): float;
}
