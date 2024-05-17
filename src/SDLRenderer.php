<?php

namespace SDL2;

use FFI;
use FFI\CData;
use FFI\CType;

class SDLRenderer
{
    private CData $sdlRenderer;
    private FFI $ffi;

    /**
     * @param CData $renderer
     * @param FFI $ffi
     */
    public function __construct(CData $renderer, FFI $ffi)
    {
        $this->sdlRenderer = $renderer;
        $this->ffi = $ffi;
    }

    public function setDrawColor(int $r, int $g, int $b, int $a): int
    {
        return $this->ffi->SDL_SetRenderDrawColor($this->sdlRenderer, $r, $g, $b, $a);
    }

    public function fillRect(SDLRect $mainRect): int
    {
        $mainRectPtr = FFI::addr($mainRect->getSdlRect());

        return $this->ffi->SDL_RenderFillRect($this->sdlRenderer, $mainRectPtr);
    }

    public function getSdlRenderer(): CData
    {
        return $this->sdlRenderer;
    }

    public function present(): void
    {
        $this->ffi->SDL_RenderPresent($this->getSdlRenderer());
    }
}