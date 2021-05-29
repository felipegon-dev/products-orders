<?php

namespace App\Tests\unit\ValueObject;

use App\Exception\InvalidParameterException;
use App\ValueObject\Name;

/**
 * Class BasicObjectTest
 */
class NameTest extends \Codeception\Test\Unit
{

    public function testCreateOK()
    {
        $this->assertEquals(Name::create('test'), 'test');
    }

    public function testCreateKO()
    {
        try {
            Name::create('a');
            $this->fail('Expected exception wasn\'t thrown!');
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidParameterException::class, $exception);
        }
    }
}
