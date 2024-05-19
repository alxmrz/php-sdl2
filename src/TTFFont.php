<?php

namespace SDL2;

use FFI\CData;

class TTFFont
{
    private $ttfFont;

    /**
     * @param CData $ttfFont
     */
    public function __construct($ttfFont)
    {
        $this->ttfFont = $ttfFont;
    }

    /**
     * @return CData
     */
    public function getTTFFont()
    {
        return $this->ttfFont;
    }
}