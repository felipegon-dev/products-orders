<?php

namespace App\Repository\Transactions;

/**
 * Interface TransactionalInterface
 */
interface TransactionalInterface
{
    /**
     * implement your aggregate invariant rules
     */
    public function run();
}
