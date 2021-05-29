<?php

namespace App\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Name
 */
class Name extends BasicObject
{
    const KEY = 'name';
    const MIN = 3;
    const MAX = 255;

    protected static function getConstrain(): Assert\Collection
    {
        return new Assert\Collection([
            Name::KEY => [
                new Assert\Length(['min' => Name::MIN, 'max' => Name::MAX]),
                new Assert\NotNull()
            ]
        ]);
    }

    protected static function getItem($key): array
    {
        return [Name::KEY => $key];
    }
}
