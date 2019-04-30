<?php

/**
 * Convert all applicable characters to HTML entities.
 *
 * @param string $text
 *
 * @return string
 */
function html($text)
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Validate E-Mail address.
 *
 * @param string $email
 *
 * @return bool
 */
function is_email($email = null)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Return Array element value.
 *
 * @param array $array
 * @param string $path
 * @param mixed|null $default
 *
 * @return mixed
 *
 * <code>
 * echo array_value($array, 'id');
 * echo array_value($array, 'city.country.name');
 * echo array_value($array, 'city.name');
 * echo array_value($array, 'city.zip', 'not set');
 * </code>
 */
function array_value(array $array, string $path, $default = null)
{
    if (strpos($path, '.') === false) {
        return $array[$path] ?? $default;
    }

    $cursor = $array;
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
 * Encode an array to JSON.
 *
 * Also makes sure the data is encoded in UTF-8.
 *
 * @param mixed $data the array to encode in JSON
 * @param int $options the encoding options
 *
 * @throws RuntimeException
 *
 * @return string the JSON encoded string
 */
function encode_json($data, int $options = 0): string
{
    if ($data instanceof JsonSerializable) {
        $data = $data->jsonSerialize();
    }

    $result = json_encode(encode_utf8($data), $options);

    if ($result === false) {
        throw new RuntimeException('Json encoding failed');
    }

    return $result;
}

/**
 * Json decoder.
 *
 * @param string $json Json string
 *
 * @return mixed the value encoded in json in appropriate PHP type
 */
function decode_json(string $json)
{
    return json_decode($json, true);
}

/**
 * Encodes an ISO-8859-1 string or array to UTF-8.
 *
 * @param mixed $data string or array to convert
 *
 * @return mixed encoded data
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
        }

        return $data;
    }
}

/**
 * Returns a ISO-8859-1 encoded string or array.
 *
 * @param mixed $data string or array to convert
 *
 * @return mixed encoded data
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
        }

        return $data;
    }
}

/**
 * Read a PHP file.
 *
 * @param string $file File
 *
 * @return mixed Data
 */
function read($file)
{
    if (!file_exists($file)) {
        throw new InvalidArgumentException(sprintf('File %s not found', $file));
    }

    return require $file;
}
