<?php

namespace Selective\Encoding;

/**
 * Unicode Full- and Half Width Encoding.
 */
final class UnicodeWidthForm
{
    /**
     * @var Utf8Encoding
     */
    private $utf8Encode;

    /**
     * @var array
     */
    private $dbc = [
        '０', '１', '２', '３', '４',
        '５', '６', '７', '８', '９',
        'Ａ', 'Ｂ', 'Ｃ', 'Ｄ', 'Ｅ',
        'Ｆ', 'Ｇ', 'Ｈ', 'Ｉ', 'Ｊ',
        'Ｋ', 'Ｌ', 'Ｍ', 'Ｎ', 'Ｏ',
        'Ｐ', 'Ｑ', 'Ｒ', 'Ｓ', 'Ｔ',
        'Ｕ', 'Ｖ', 'Ｗ', 'Ｘ', 'Ｙ',
        'Ｚ', 'ａ', 'ｂ', 'ｃ', 'ｄ',
        'ｅ', 'ｆ', 'ｇ', 'ｈ', 'ｉ',
        'ｊ', 'ｋ', 'ｌ', 'ｍ', 'ｎ',
        'ｏ', 'ｐ', 'ｑ', 'ｒ', 'ｓ',
        'ｔ', 'ｕ', 'ｖ', 'ｗ', 'ｘ',
        'ｙ', 'ｚ', '－', '　', '：',
        '．', '，', '／', '％', '＃',
        '！', '＠', '＆', '（', '）',
        '＜', '＞', '＂', '＇', '？',
        '［', '］', '｛', '｝', '＼',
        '｜', '＋', '＝', '＿', '＾',
        '￥', '￣', '｀', '＄',
    ];

    /**
     * @var array
     */
    private $sbc = [
        '0', '1', '2', '3', '4',
        '5', '6', '7', '8', '9',
        'A', 'B', 'C', 'D', 'E',
        'F', 'G', 'H', 'I', 'J',
        'K', 'L', 'M', 'N', 'O',
        'P', 'Q', 'R', 'S', 'T',
        'U', 'V', 'W', 'X', 'Y',
        'Z', 'a', 'b', 'c', 'd',
        'e', 'f', 'g', 'h', 'i',
        'j', 'k', 'l', 'm', 'n',
        'o', 'p', 'q', 'r', 's',
        't', 'u', 'v', 'w', 'x',
        'y', 'z', '-', ' ', ':',
        '.', ',', '/', '%', '#',
        '!', '@', '&', '(', ')',
        '<', '>', '"', '\'', '?',
        '[', ']', '{', '}', '\\',
        '|', ' ', '=', '_', '^',
        '￥', '~', '`', '$',
    ];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->utf8Encode = new Utf8Encoding();
    }

    /**
     * Encodes a string to half width string.
     *
     * @param string $data The value to encode
     *
     * @return string The encoded value
     */
    public function encodeHalfWidthString(string $data): string
    {
        if ($data === '') {
            return $data;
        }

        $data = $this->utf8Encode->encodeUtf8($data);

        $string = '';
        $len = mb_strlen($data);

        for ($index = 0; $index < $len; $index++) {
            $character = mb_substr($data, $index, 1);

            if ($this->stringWidth($character) === 2) {
                $character = $this->encodeToSbc($character);
            }

            if ($this->stringWidth($character) === 1) {
                $string .= $character;
            }
        }

        return $string;
    }

    /**
     * Encodes a string to full width string.
     *
     * @param string $data The value to encode
     *
     * @return string The encoded value
     */
    public function encodeFullWidthString(string $data): string
    {
        if ($data === '') {
            return $data;
        }

        $data = $this->utf8Encode->encodeUtf8($data);

        $string = '';
        $len = mb_strlen($data);

        for ($index = 0; $index < $len; $index++) {
            $character = mb_substr($data, $index, 1);

            if ($this->stringWidth($character) === 1) {
                $character = $this->encodeToDbc($character);
            }

            if ($this->stringWidth($character) === 2) {
                $string .= $character;
            }
        }

        return $string;
    }

    /**
     * Encode to SBC.
     *
     * @param string $character The character
     *
     * @return string The result
     */
    private function encodeToSbc(string $character): string
    {
        return str_replace($this->dbc, $this->sbc, $character);
    }

    /**
     * Encode to DBC.
     *
     * @param string $character The character
     *
     * @return string The result
     */
    private function encodeToDbc(string $character): string
    {
        return str_replace($this->sbc, $this->dbc, $character);
    }

    /**
     * Get the visual width of a string - the number of columns required to display it.
     *
     * @param string $data The string
     *
     * @return int The visual width
     */
    private function stringWidth(string $data): int
    {
        return mb_strwidth($data);
    }
}
