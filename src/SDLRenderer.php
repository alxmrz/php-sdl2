<?php

namespace SDL2;

use FFI;
use FFI\CType;

class SDLRenderer
{
    private $sdlRenderer;
    private FFI $ffi;

    /**
     * @param $renderer
     * @param FFI $ffi
     */
    public function __construct($renderer, FFI $ffi)
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

    public function getSdlRenderer()
    {
        return $this->sdlRenderer;
    }

    public function present(): void
    {
        $this->ffi->SDL_RenderPresent($this->getSdlRenderer());
    }

    public function copy($texture, ?SDLRect $source = null, ?SDLRect $destination = null): int
    {
        $sourceRectPtr = null;
        $destinationRectPtr = null;

        if ($source !== null) {
            $sourceRect = $this->ffi->new('SDL_Rect');
            $sourceRect->x = $source->getX();
            $sourceRect->y = $source->getY();
            $sourceRect->w = $source->getWidth();
            $sourceRect->h = $source->getHeight();

            $sourceRectPtr = FFI::addr($sourceRect);
        }

        if ($destination !== null) {
            $destinationRect = $this->ffi->new('SDL_Rect');
            $destinationRect->x = $destination->getX();
            $destinationRect->y = $destination->getY();
            $destinationRect->w = $destination->getWidth();
            $destinationRect->h = $destination->getHeight();

            $destinationRectPtr = FFI::addr($destinationRect);
        }

        $result = $this->ffi->SDL_RenderCopy(
            $this->getSdlRenderer(),
            $texture,
            $sourceRectPtr,
            $destinationRectPtr
        );

        if ($destinationRectPtr) {
            FFI::free($destinationRectPtr);
        }

        return $result;
    }

    public function clear(): int
    {
        return $this->ffi->SDL_RenderClear($this->getSdlRenderer());
    }
}