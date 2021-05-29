<?php

namespace App\Repository\Transactions;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Transactional
 */
class Transactional
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Transactional constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param TransactionalInterface $transactional
     *
     * @throws \Exception
     */
    public function run(TransactionalInterface $transactional)
    {
        $this->em->beginTransaction();

        try {
            $data = $transactional->run();
            $this->em->commit();

            return $data;
        } catch (\Exception $exception) {
            $this->em->rollback();
            throw $exception;
        }
    }
}
