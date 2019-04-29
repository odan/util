<?php

namespace Selective\Util\Test;

use PHPUnit\Framework\TestCase;

/**
 * UtilTest
 */
class UtilTest extends TestCase
{

    /**
     * Test.
     *
     * @return void
     */
    public function testUuid(): void
    {
        $actual = preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', uuid());
        $this->assertSame(1, $actual);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testArrayValue()
    {
        $arr = array(
            'key' => 1,
            'sub' => array(
                'sub2' => 'test'
            )
        );
        $this->assertSame(1, array_value($arr, 'key'));
        $this->assertNull(array_value($arr, 'nada'));
        $this->assertNull(array_value($arr, '..'));
        $this->assertSame('test', array_value($arr, 'sub.sub2'));
    }

    /**
     * Test.
     *
     * @expectedException \TypeError
     *
     * @return void
     */
    public function testArrayValueWithNotArrayArgument(): void
    {
        $this->assertNull(array_value('invalid_array', 'path'));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testHtml(): void
    {
        $this->assertIsString(html('<script></script>'));
        $this->assertSame('&lt;script&gt;&lt;/script&gt;', html('<script></script>'));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testIsEmail(): void
    {
        $this->assertTrue(is_email('name@example.com'));
        $this->assertFalse(is_email('invalid_email_address'));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeJson(): void
    {
        $jsonArr = array(
            'key1' => 'value1',
            'key2' => 'value2',
        );
        $this->assertSame('{"key1":"value1","key2":"value2"}', encode_json($jsonArr));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeJsonOnJsonSerializable(): void
    {
        $jsonObject = new FooJson();

        $this->assertSame('{"key":"value"}', encode_json($jsonObject));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testDecodeJson(): void
    {
        $jsonStr = '{"key1":"value1","key2":"value2"}';
        $decodeArr = decode_json($jsonStr, true);
        $this->assertArrayHasKey('key1', $decodeArr);
        $this->assertArrayHasKey('key2', $decodeArr);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeUtf8WithNullArgument(): void
    {
        $this->assertSame('', encode_utf8(''));
        $this->assertNull(encode_utf8(null));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeIsoWithNullArgument(): void
    {
        $this->assertSame('', encode_iso(''));
        $this->assertNull(encode_iso(null));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeIsoWithArrayArgument(): void
    {
        $isoResult = encode_iso(array('123'));
        $this->assertSame('123', $isoResult[0]);
    }

    /**
     * Test.
     *
     * @expectedException InvalidArgumentException
     */
    public function testReadWithErrorFilePath(): void
    {
        read('./error_file_path');
    }
}
