<?php

namespace Odan\Util\Test;

/**
 * UtilTest
 */
class UtilTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Test.
     *
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
     * @return void
     */
    public function testHtml()
    {
        $this->assertInternalType('string', html('<script></script>'));
        $this->assertSame('&lt;script&gt;&lt;/script&gt;', html('<script></script>'));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testIsEmail()
    {
        $this->assertTrue(is_email('name@example.com'));
        $this->assertFalse(is_email('invalid_email_address'));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeUtf8WithNullArgument()
    {
        $this->assertSame('', encode_utf8(''));
        $this->assertNull(encode_utf8(null));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeIsoWithNullArgument()
    {
        $this->assertSame('', encode_iso(''));
        $this->assertNull(encode_iso(null));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeIsoWithArrayArgument()
    {
        $isoResult = encode_iso(array('123'));
        $this->assertSame('123', $isoResult[0]);
    }

    /**
     * Test.
     *
     * @expectedException InvalidArgumentException
     */
    public function testReadWithErrorFilePath()
    {
        read('./error_file_path');
    }
}
