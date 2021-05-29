<?php

namespace App\Tests\unit\ValueObject;

use App\Exception\InvalidParameterException;
use App\ValueObject\BasicObject;

/**
 * Class BasicObjectTest
 */
class BasicObjectTest extends \Codeception\Test\Unit
{

    public function testCreateOK()
    {
        $this->assertEquals(BasicObject::create('test'), 'test');
    }

    public function testCreateKO()
    {
        try {
            BasicObject::create();
            $this->fail('Expected exception wasn\'t thrown!');
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidParameterException::class, $exception);
        }
    }
}
