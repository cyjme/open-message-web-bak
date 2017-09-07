<?php
namespace phpunit\Gap\Valid;

use Gap\Valid\DateTimeAtomValid;

class DateTimeAtomValidTest extends \PHPUnit_Framework_TestCase
{
    public function testAssert()
    {
        $now = date(DATE_ATOM);
        obj(new DateTimeAtomValid())->assert($now);
    }

    /**
     * @expectedException Gap\Exception\ClientException
     */
    public function testFailingAssert()
    {
        obj(new DateTimeAtomValid())->assert('');
    }
}
