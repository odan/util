<?php

/**
 * Generates a normalized URI for the given path.
 *
 * @param string $path A path to use instead of the current one
 * @param boolean $full return absolute or relative url
 * @return string The normalized URI for the path
 */

namespace Odan\Util\Test;

/**
 * UtilTest
 */
class UtilTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test.
     *
     * @covers ::gh
     * @return void
     */
    public function testGh()
    {
        $this->assertSame('', gh(null));
        $this->assertSame('', gh(''));
        $this->assertSame('abc', gh('abc'));
    }

    /**
     * Test.
     *
     * @covers ::wh
     * @return void
     */
    public function testWh()
    {
        $this->assertSame(null, wh(null));
    }

    /**
     * Test.
     *
     * @covers ::now
     * @return void
     */
    public function testNow()
    {
        $this->assertSame(date('Y-m-d H:i:s'), now());
    }

    /**
     * Test.
     *
     * @covers ::uuid
     * @return void
     */
    public function testUuid()
    {
        $actual = preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', uuid());
        $this->assertSame(1, $actual);
    }

    /**
     * Test.
     *
     * @covers ::value
     * @return void
     */
    public function testValue()
    {
        $arr = array(
            'key' => 1,
            'sub' => array(
                'sub2' => 'test'
            )
        );
        $this->assertSame(1, value($arr, 'key'));
        $this->assertSame(null, value($arr, 'nada'));
        $this->assertSame('test', value($arr, 'sub.sub2'));
    }

}
