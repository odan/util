<?php

namespace Selective\Encoding;

class UnicodeWidthForm
{
    /** @var Utf8Encoding */
    private $utf8Encode;

    public function __construct()
    {
        $this->utf8Encode = new Utf8Encoding();
    }

    /**
     * Encodes a string to half width string
     *
     * @param string $data
     *
     * @return string
     */
    public function encodeHalfWidthString(string $data = '')
    {
        $data = $this->utf8Encode->encodeUtf8($data);

        if ($data === '') {
            return $data;
        }

        $string = '';
        $len = mb_strlen($data);
        for ($index = 0; $index < $len; $index++) {
            $character = mb_substr($data, $index, 1);
            if ($this->stringWidth($character) === 2) {
                $character = $this->replaceWidthString($character, 'TOSBC');
            }

            if ($this->stringWidth($character) === 1) {
                $string .= $character;
            }
        }

        return $string;
    }

    /**
     * Encodes a string to full width string
     *
     * @param string $data
     *
     * @return string
     */
    public function encodeFullWidthString(string $data = '')
    {
        $data = $this->utf8Encode->encodeUtf8($data);

        if ($data === '') {
            return $data;
        }

        $string = '';
        $len = mb_strlen($data);
        for ($index = 0; $index < $len; $index++) {
            $character = mb_substr($data, $index, 1);
            if ($this->stringWidth($character) === 1) {
                $character = $this->replaceWidthString($character, 'TODBC');
            }

            if ($this->stringWidth($character) === 2) {
                $string .= $character;
            }
        }

        return $string;
    }

    private function replaceWidthString(string $character, string $type = 'TODBC')
    {
        $dbc = [
            '０' , '１' , '２' , '３' , '４' ,
            '５' , '６' , '７' , '８' , '９' ,
            'Ａ' , 'Ｂ' , 'Ｃ' , 'Ｄ' , 'Ｅ' ,
            'Ｆ' , 'Ｇ' , 'Ｈ' , 'Ｉ' , 'Ｊ' ,
            'Ｋ' , 'Ｌ' , 'Ｍ' , 'Ｎ' , 'Ｏ' ,
            'Ｐ' , 'Ｑ' , 'Ｒ' , 'Ｓ' , 'Ｔ' ,
            'Ｕ' , 'Ｖ' , 'Ｗ' , 'Ｘ' , 'Ｙ' ,
            'Ｚ' , 'ａ' , 'ｂ' , 'ｃ' , 'ｄ' ,
            'ｅ' , 'ｆ' , 'ｇ' , 'ｈ' , 'ｉ' ,
            'ｊ' , 'ｋ' , 'ｌ' , 'ｍ' , 'ｎ' ,
            'ｏ' , 'ｐ' , 'ｑ' , 'ｒ' , 'ｓ' ,
            'ｔ' , 'ｕ' , 'ｖ' , 'ｗ' , 'ｘ' ,
            'ｙ' , 'ｚ' , '－' , '　' , '：' ,
            '．' , '，' , '／' , '％' , '＃' ,
            '！' , '＠' , '＆' , '（' , '）' ,
            '＜' , '＞' , '＂' , '＇' , '？' ,
            '［' , '］' , '｛' , '｝' , '＼' ,
            '｜' , '＋' , '＝' , '＿' , '＾' ,
            '￥' , '￣' , '｀', '＄'
        ];

        $sbc = [
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
            '<', '>', '"', '\'','?',
            '[', ']', '{', '}', '\\',
            '|', ' ', '=', '_', '^',
            '￥','~', '`', '$'
        ];

        if ($type == 'TODBC') {
            return str_replace($sbc, $dbc, $character);
        }

        if ($type == 'TOSBC') {
            return str_replace($dbc, $sbc, $character);
        }
    }

    /**
     * Get the visual width of a string - the number of columns required to display it
     *
     * @param string $data
     *
     * @return int
     */
    private function stringWidth(string $data)
    {
        return mb_strwidth($data);
    }
}
