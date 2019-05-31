<?php

namespace Selective\Encoding\Test;

use PHPUnit\Framework\TestCase;
use Selective\Encoding\HtmlEncoding;
use Selective\Encoding\IsoEncoding;
use Selective\Encoding\JsonEncoding;
use Selective\Encoding\UnicodeWidthForm;
use Selective\Encoding\Utf8Encoding;

/**
 * Test.
 */
class EncodingTest extends TestCase
{
    /**
     * Test.
     *
     * @return void
     */
    public function testHtml(): void
    {
        $this->assertIsString((new HtmlEncoding())->encodeHtml('<script></script>'));
        $this->assertSame('&lt;script&gt;&lt;/script&gt;', (new HtmlEncoding())->encodeHtml('<script></script>'));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeJson(): void
    {
        $jsonArr = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];
        $this->assertSame('{"key1":"value1","key2":"value2"}', (new JsonEncoding())->encodeJson($jsonArr));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeJsonOnJsonSerializable(): void
    {
        $jsonObject = new FooJson();

        $this->assertSame('{"key":"value"}', (new JsonEncoding())->encodeJson($jsonObject));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testDecodeJson(): void
    {
        $jsonStr = '{"key1":"value1","key2":"value2"}';
        $decodeArr = (new JsonEncoding())->decodeJson($jsonStr);
        $this->assertArrayHasKey('key1', $decodeArr);
        $this->assertArrayHasKey('key2', $decodeArr);

        $decodeArr = (new JsonEncoding())->decodeJson('{}');
        $this->assertIsArray($decodeArr);
        $this->assertEmpty($decodeArr);

        $decodeArr = (new JsonEncoding())->decodeJson('"null"');
        $this->assertSame('null', $decodeArr);

        $decodeArr = (new JsonEncoding())->decodeJson('null');
        $this->assertNull($decodeArr);

        $decodeArr = (new JsonEncoding())->decodeJson('"false"');
        $this->assertSame('false', $decodeArr);

        $decodeArr = (new JsonEncoding())->decodeJson('false');
        $this->assertFalse($decodeArr);

        $decodeArr = (new JsonEncoding())->decodeJson('"true"');
        $this->assertSame('true', $decodeArr);

        $decodeArr = (new JsonEncoding())->decodeJson('true');
        $this->assertTrue($decodeArr);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeUtf8WithNullArgument(): void
    {
        $this->assertSame('', (new Utf8Encoding())->encodeUtf8(''));
        $this->assertNull((new Utf8Encoding())->encodeUtf8(null));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeUtf8WithNonUtf8(): void
    {
        $data = "\x00\x81";
        $this->assertNotSame($data, (new Utf8Encoding())->encodeUtf8($data));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeIsoWithNullArgument(): void
    {
        $this->assertSame('', (new IsoEncoding())->encodeIso(''));
        $this->assertNull((new IsoEncoding())->encodeIso(null));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeIsoWithArrayArgument(): void
    {
        $isoResult = (new IsoEncoding())->encodeIso(['123']);
        $this->assertSame('123', $isoResult[0]);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeIsoWithNonUtf8Data(): void
    {
        $data = "\x00\x81";
        $this->assertSame($data, (new IsoEncoding())->encodeIso($data));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testUnicodeWidthFormWithFullWidthString(): void
    {
        $string = '012345678090古';
        $unicodeWidthForm = new UnicodeWidthForm();

        $this->assertSame('０１２３４５６７８０９０古', $unicodeWidthForm->encodeFullWidthString($string));
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testUnicodeWidthFormWithHalfWidthString(): void
    {
        $string = '！＠＃＃＄＄％古';
        $unicodeWidthForm = new UnicodeWidthForm();

        $this->assertSame('!@##$$%', $unicodeWidthForm->encodeHalfWidthString($string));
    }
}
