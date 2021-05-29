<?php

namespace App\Tests\unit\ValueObject;

use App\Exception\InvalidParameterException;
use App\ValueObject\Price;

/**
 * Class PriceTest
 */
class PriceTest extends \Codeception\Test\Unit
{

    public function testCreateOK()
    {
        $this->assertEquals(Price::create(1)->get(), 1);
    }

    public function testCreateKO()
    {
        try {
            Price::create(-10);
            $this->fail('Expected exception wasn\'t thrown!');
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidParameterException::class, $exception);
        }
    }
}
