<?php

namespace SDL2;

use FFI;
use FFI\CData;

class SDLWindow
{
    private $sdlWindow;

    public function __construct($sdlWindow)
    {
        $this->sdlWindow = $sdlWindow;
    }

    public function getSdlWindow()
    {
        return $this->sdlWindow;
    }
}