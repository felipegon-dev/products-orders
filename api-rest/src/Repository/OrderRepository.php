<?php

namespace App\Repository;

use App\Entity\Order;
use App\Repository\Contracts\OrderRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @return Order
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(float $totalPrice = 0): Order
    {
        $order = new Order();
        $order->setTotalPrice($totalPrice);
        $this->_em->persist($order);
        $this->_em->flush();

        return $order;
    }

    /**
     * @param Order $order
     */
    public function update(Order $order): Order
    {
        $this->_em->persist($order);
        $this->_em->flush();

        return $order;
    }
}
