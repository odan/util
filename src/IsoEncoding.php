<?php

namespace Selective\Encoding;

/**
 * ISO Encoding.
 */
final class IsoEncoding
{
    /**
     * Returns a ISO-8859-1 encoded string or array.
     *
     * @param mixed $data string or array to convert
     *
     * @return mixed encoded data
     */
    public function encodeIso($data)
    {
        if ($data === null || $data === '') {
            return $data;
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->encodeIso($value);
            }

            return $data;
        }

        if (is_string($data) && mb_check_encoding($data, 'UTF-8')) {
            return mb_convert_encoding($data, 'ISO-8859-1', 'auto');
        }

        return $data;
    }
}
