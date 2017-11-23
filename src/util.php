<?php

/**
 * Convert all applicable characters to HTML entities.
 *
 * @param string $text
 * @return string
 */
function gh($text)
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Write html encoded string.
 *
 * @param string $str
 */
function wh($str)
{
    echo gh($str);
}

/**
 * Validate E-Mail address
 *
 * @param string $email
 * @return boolean
 */
function is_email($email = null)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Shorthand for now function
 *
 * @return string ISO date time (Y-m-d H:i:s)
 */
function now()
{
    return date('Y-m-d H:i:s');
}

/**
 * Returns a `UUID` v4 created from a cryptographically secure random value.
 *
 * @return string UUID version 4
 */
function uuid()
{
    // Generate a cryptographically secure random value
    $bytes = openssl_random_pseudo_bytes(16);
    $hash = bin2hex($bytes);

    // Applies the RFC 4122 version number to the `time_hi_and_version` field
    $version = 4;
    $timeHi = hexdec(substr($hash, 12, 4)) & 0x0fff;
    $timeHi &= ~(0xf000);
    $timeHi |= $version << 12;

    // Applies the RFC 4122 variant field to the `clock_seq_hi_and_reserved` field
    $clockSeqHi = hexdec(substr($hash, 16, 2));
    $clockSeqHi = $clockSeqHi & 0x3f;
    $clockSeqHi &= ~(0xc0);
    $clockSeqHi |= 0x80;

    $fields = array(
        'time_low' => substr($hash, 0, 8),
        'time_mid' => substr($hash, 8, 4),
        'time_hi_and_version' => str_pad(dechex($timeHi), 4, '0', STR_PAD_LEFT),
        'clock_seq_hi_and_reserved' => str_pad(dechex($clockSeqHi), 2, '0', STR_PAD_LEFT),
        'clock_seq_low' => substr($hash, 18, 2),
        'node' => substr($hash, 20, 12),
    );

    return vsprintf('%08s-%04s-%04s-%02s%02s-%012s', array_values($fields));
}

/**
 * Return Array element value (get value).
 *
 * @param array $arr
 * @param string $path
 * @param null|mixed $default
 * @return mixed
 *
 * <code>
 * echo value($arr, 'id');
 * echo value($arr, 'city.country.name');
 * echo value($arr, 'city.name');
 * echo value($arr, 'city.zip', 'not set');
 * </code>
 */
function value($arr, $path, $default = null)
{
    if (!is_array($arr)) {
        return $default;
    }

    $cursor = $arr;
    $keys = explode('.', $path);

    foreach ($keys as $key) {
        if (isset($cursor[$key])) {
            $cursor = $cursor[$key];
        } else {
            return $default;
        }
    }

    return $cursor;
}

/**
 * Encode an array to JSON
 *
 * Also makes sure the data is encoded in UTF-8.
 *
 * @param array $data The array to encode in JSON.
 * @param int $options The encoding options.
 * @return string The JSON encoded string.
 */
function encode_json($data, $options = 0)
{
    return json_encode(encode_utf8($data), $options);
}

/**
 * Json decoder
 *
 * @param string $json Json string
 * @return mixed Json The value encoded in json in appropriate PHP type.
 */
function decode_json($json)
{
    return json_decode($json, true);
}

/**
 * Encodes an ISO-8859-1 string or array to UTF-8.
 *
 * @param mixed $data String or array to convert.
 * @return mixed Encoded data.
 */
function encode_utf8($data)
{
    if ($data === null || $data === '') {
        return $data;
    }
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = encode_utf8($value);
        }
        return $data;
    } else {
        if (!mb_check_encoding($data, 'UTF-8')) {
            return mb_convert_encoding($data, 'UTF-8');
        } else {
            return $data;
        }
    }
}

/**
 * Returns a ISO-8859-1 encoded string or array.
 *
 * @param mixed $data String or array to convert.
 * @return mixed Encoded data.
 */
function encode_iso($data)
{
    if ($data === null || $data === '') {
        return $data;
    }
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = encode_iso($value);
        }
        return $data;
    } else {
        if (mb_check_encoding($data, 'UTF-8')) {
            return mb_convert_encoding($data, 'ISO-8859-1', 'auto');
        } else {
            return $data;
        }
    }
}

/**
 * Read php file.
 *
 * @param string $file File
 * @return mixed Data
 */
function read($file)
{
    return require $file;
}
