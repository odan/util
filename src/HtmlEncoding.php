<?php

namespace Selective\Encoding;

/**
 * HTML Encoding.
 */
final class HtmlEncoding
{
    /**
     * Convert all applicable characters to HTML entities.
     *
     * @param string $text The content to encode to html
     *
     * @return string the encoded html string
     */
    public function encodeHtml(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
