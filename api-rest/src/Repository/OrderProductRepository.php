<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Repository\Contracts\OrderProductRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderProduct[]    findAll()
 * @method OrderProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderProductRepository extends ServiceEntityRepository implements OrderProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderProduct::class);
    }

    // TOOD: remove?
    /**
     * @param Product $product
     * @param Order   $order
     *
     * @return OrderProduct
     */
    public function save(Product $product, Order $order): OrderProduct
    {
        $orderProduct = new OrderProduct();
        $orderProduct->setOrder($order);
        $orderProduct->setProduct($product);
        $this->_em->persist($orderProduct);
        $this->_em->flush($orderProduct);

        return $orderProduct;
    }

    /**
     * @param Order $order
     *
     * @return OrderProduct[]
     */
    public function getProductsQuantity(Order $order): array
    {
        return $this->createQueryBuilder('op')
            ->leftJoin('op.product', 'p')
            ->select('p.id, count(p.id) as quantity')
            ->andWhere('op.order = :val')->setParameter('val', $order->getId())
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Order $order
     *
     * @return float
     */
    public function getSumPrice(Order $order): float
    {
        $result = $this->createQueryBuilder('op')
            ->leftJoin('op.product', 'p')
            ->select('sum(p.price) as totalPrice')
            ->andWhere('op.order = :val')->setParameter('val', $order->getId())
            ->getQuery()
            ->getSingleResult();

        return isset($result['totalPrice']) ? $result['totalPrice'] : 0;
    }
}
