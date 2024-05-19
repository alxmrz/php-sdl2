<?php

namespace SDL2;

use FFI;
use FFI\CData;

class SDLWindow
{
    private $sdlWindow;
    private FFI $ffi;

    public function __construct($sdlWindow, FFI $ffi)
    {
        $this->sdlWindow = $sdlWindow;
        $this->ffi = $ffi;
    }

    public function createRenderer(int $index, int $flags): ?SDLRenderer
    {
        $renderer = $this->ffi->SDL_CreateRenderer($this->sdlWindow, $index, $flags);
        if (!$renderer) {
            return null;
        }

        return new SDLRenderer($renderer, $this->ffi);
    }

    public function updateSurface(): int
    {
        return $this->ffi->SDL_UpdateWindowSurface($this->sdlWindow);
    }

    public function destroyRenderer(SDLRenderer $renderer)
    {
        $this->ffi->SDL_DestroyRenderer($renderer->getSdlRenderer());
    }

    public function getSdlWindow()
    {
        return $this->sdlWindow;
    }
}