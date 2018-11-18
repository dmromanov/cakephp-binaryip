<?php


namespace BinaryIp\Tests\TestCase\Database\Type;

use Cake\Database\Driver;
use Cake\Database\Expression\FunctionExpression;
use Cake\TestSuite\TestCase;
use BinaryIp\Database\Type\BinaryIpType;
use function inet_ntop;

/**
 * @property BinaryIpType Type
 */
class BinaryIpTypeTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Type = new BinaryIpType();
    }

    public function testToPHP()
    {
        $expected = '127.0.0.1';
        $result = $this->Type->toPHP(inet_pton('127.0.0.1'), $this->createMock(Driver::class));
        $this->assertSame($expected, $result);
    }

    public function testToDatabase()
    {
        $expected = inet_pton('127.0.0.1');
        $result = $this->Type->toDatabase('127.0.0.1', $this->createMock(Driver::class));
        $this->assertSame($expected, $result);
    }
}
