<?php

namespace App\Repository\Contracts;

use App\Entity\Order;

interface OrderRepositoryInterface
{
    /**
     * @return Order
     */
    public function save(): Order;

    /**
     * @param Order $order
     *
     * @return Order
     */
    public function update(Order $order): Order;
}
