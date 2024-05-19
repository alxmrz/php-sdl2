<?php

namespace SDL2;

class SDLSurface
{
    private $sdlSurface;

    public function __construct($sdlSurface = null)
    {

        $this->sdlSurface = $sdlSurface;
    }

    public function getSdlSurface()
    {
        return $this->sdlSurface;
    }

    /**
     * @param mixed $sdlSurface
     */
    public function setSdlSurface($sdlSurface): void
    {
        $this->sdlSurface = $sdlSurface;
    }
}