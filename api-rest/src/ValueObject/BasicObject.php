<?php

namespace App\ValueObject;

use App\Exception\InvalidParameterException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

/**
 * Class BasicObject
 */
class BasicObject
{
    const KEY = 'key';

    /**
     * @var mixed
     */
    protected $key;

    /**
     * BasicObject constructor.
     *
     * @param $key
     */
    protected function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @param string|null $key
     *
     * @return static
     */
    public static function create($key = null): self
    {
        $errors = static::validate($key, static::getConstrain());
        if (count($errors) > 0) {
            throw new InvalidParameterException($errors);
        }

        return new static($key);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->key;
    }

    /**
     * @param $key
     *
     * @return array
     */
    protected static function getItem($key): array
    {
        return [BasicObject::KEY => $key];
    }

    /**
     * @return Assert\Collection
     */
    protected static function getConstrain(): Assert\Collection
    {
        return new Assert\Collection([
            BasicObject::KEY => new Assert\NotNull()
        ]);
    }

    /**
     * @param                   $key
     * @param Assert\Collection $constraint
     *
     * @return ConstraintViolationListInterface
     */
    private static function validate($key, Assert\Collection $constraint): ConstraintViolationListInterface
    {
        $validator = Validation::createValidator();

        return $validator->validate(static::getItem($key), $constraint);
    }
}
