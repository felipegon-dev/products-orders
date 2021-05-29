<?php

namespace App\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Name
 */
class Price extends BasicObject
{
    const KEY = 'price';
    const MIN = 1;
    const MAX = 100;

    /**
     * @return float
     */
    public function get(): float
    {
        return $this->key;
    }

    protected static function getConstrain(): Assert\Collection
    {
        return new Assert\Collection([
            Price::KEY => [
                new Assert\Range(['min' => Price::MIN, 'max' =>  Price::MAX]),
                new Assert\NotNull()
            ]
        ]);
    }

    protected static function getItem($key): array
    {
        return [Price::KEY => $key];
    }
}
