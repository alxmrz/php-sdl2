<?php

namespace SDL2;

class SDLRenderer
{
    private $sdlRenderer;

    /**
     * @param $renderer
     */
    public function __construct($renderer)
    {
        $this->sdlRenderer = $renderer;
    }

    public function getSdlRenderer()
    {
        return $this->sdlRenderer;
    }
}