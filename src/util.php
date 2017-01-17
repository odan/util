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
 * Returns a random UUID
 *
 * @return string
 */
function uuid()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for time low
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        // 16 bits for time mid
        mt_rand(0, 0xffff),
        // 16 bits for time hi and version,
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,
        // 16 bits, 8 bits for clk seq hi res,
        // 8 bits for clk_seq_low,
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,
        // 48 bits for node
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
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
