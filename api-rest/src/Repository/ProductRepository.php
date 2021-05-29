<?php

namespace App\Repository;

use App\Entity\Product;
use App\Repository\Contracts\ProductRepositoryInterface;
use App\ValueObject\Name;
use App\ValueObject\Price;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param Name $name
     *
     * @return bool
     */
    public function has(Name $name): bool
    {
        return (count($this->findBy(['name' => $name])) > 0);
    }

    /**
     * @param Name  $name
     * @param Price $price
     *
     * @return Product
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Name $name, Price $price): Product
    {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price->get());
        $this->_em->persist($product);
        $this->_em->flush();

        return $product;
    }
}
