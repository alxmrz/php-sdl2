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
        $sdlRect = $this->ffi->new('SDL_Rect');
        $sdlRect->x = $mainRect->getX();
        $sdlRect->y = $mainRect->getY();
        $sdlRect->w = $mainRect->getWidth();
        $sdlRect->h = $mainRect->getHeight();

        $sdlRectPtr = FFI::addr($sdlRect);

        $result = $this->ffi->SDL_RenderFillRect($this->sdlRenderer, $sdlRectPtr);

        FFI::free($sdlRectPtr);

        return $result;
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