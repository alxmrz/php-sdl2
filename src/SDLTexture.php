<?php

namespace SDL2;

use FFI\CData;

class SDLTexture
{
    private $sdlTexture;

    /**
     * @param CData $sdlTexture
     */
    public function __construct($sdlTexture)
    {
        $this->sdlTexture = $sdlTexture;
    }

    /**
     * @return CData
     */
    public function getSdlTexture()
    {
        return $this->sdlTexture;
    }
}