<?php

namespace Selective\Encoding;

/**
 * UTF-8 Encoding.
 */
final class Utf8Encoding
{
    /**
     * Encodes an ISO-8859-1 string or array to UTF-8.
     *
     * @param mixed $data string or array to convert
     *
     * @return mixed encoded data
     */
    public function encodeUtf8($data)
    {
        if ($data === null || $data === '') {
            return $data;
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->encodeUtf8($value);
            }

            return $data;
        }

        if (is_string($data) && !mb_check_encoding($data, 'UTF-8')) {
            return mb_convert_encoding($data, 'UTF-8');
        }

        return $data;
    }
}
