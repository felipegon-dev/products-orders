<?php

namespace App\Repository\Contracts;

use App\ValueObject\Name;
use App\ValueObject\Price;

interface ProductRepositoryInterface
{
    /**
     * @param Name $name
     *
     * @return bool
     */
    public function has(Name $name): bool;

    /**
     * @param Name  $name
     * @param Price $price
     *
     * @return mixed
     */
    public function save(Name $name, Price $price);
}
