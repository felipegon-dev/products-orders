<?php

namespace App\Aggregate\OrderProduct;

use App\DTO\OrderProductDTO;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Repository\Transactions\TransactionalInterface;

/**
 * Class OrderProductAggregate
 */
class OrderProductAggregate implements TransactionalInterface
{
    /**
     * @var OrderProductEntities
     */
    private $entity;
    /**
     * @var OrderProductRepositories
     */
    private $repo;

    /**
     * OrderProductAggregate constructor.
     *
     * @param OrderProductEntities     $entity
     * @param OrderProductRepositories $repo
     */
    public function __construct(OrderProductEntities $entity, OrderProductRepositories $repo)
    {
        $this->entity = $entity;
        $this->repo = $repo;
    }


    public function run()
    {
        $this->saveOrderProduct();
        $order = $this->updateOrder($this->getTotalPrice());
        $qty = $this->getProductsQuantity();

        return new OrderProductDTO($order, $qty);
    }

    /**
     * @return OrderProduct
     */
    private function saveOrderProduct(): OrderProduct
    {
        return $this->repo->getOrderProductRepo()->save($this->entity->getProduct(), $this->entity->getOrder());
    }

    /**
     * @return Order
     */
    private function updateOrder(float $totalPrice): Order
    {
        $this->entity->getOrder()->setTotalPrice($totalPrice);

        return $this->repo->getOrderRepo()->update($this->entity->getOrder());
    }

    /**
     * @return array
     */
    private function getProductsQuantity(): array
    {
        return $this->repo->getOrderProductRepo()->getProductsQuantity($this->entity->getOrder());
    }

    /**
     * @return float
     */
    private function getTotalPrice(): float
    {
        return $this->repo->getOrderProductRepo()->getSumPrice($this->entity->getOrder());
    }
}
