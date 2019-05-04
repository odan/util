<?php

namespace Selective\Encoding;

use JsonException;
use JsonSerializable;
use RuntimeException;

/**
 * JSON encoding.
 */
final class JsonEncoding
{
    /**
     * @var Utf8Encoding
     */
    private $utf8Encoding;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->utf8Encoding = new Utf8Encoding();
    }

    /**
     * Encode an array to JSON.
     *
     * Also makes sure the data is encoded in UTF-8.
     *
     * @param mixed $data the array to encode in JSON
     *
     * @throws RuntimeException
     *
     * @return string the JSON encoded string
     */
    public function encode($data): string
    {
        if ($data instanceof JsonSerializable) {
            $data = $data->jsonSerialize();
        }

        $result = json_encode($this->utf8Encoding->encodeUtf8($data), 512, JSON_THROW_ON_ERROR);

        if ($result === false) {
            throw new JsonException('Json encoding failed');
        }

        return $result;
    }

    /**
     * Json decoder.
     *
     * @param string $json Json string
     *
     * @throws JsonException
     *
     * @return mixed the value encoded in json in appropriate PHP type
     */
    public function decode(string $json)
    {
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }
}