<?php

namespace SDL2;

use FFI;

class LibSDL2 extends Library
{
    public const int INIT_EVERYTHING = (
        0x00000001 |
        0x00000010 |
        0x00000020 |
        0x00004000 |
        0x00000200 |
        0x00001000 |
        0x00002000 |
        0x00008000
    );

    protected const string LIB_SHARED_BINARY_FILE = 'libSDL2.so';
    protected const string PATH_TO_LIBRARY_HEADERS = __DIR__ . '/headers/SDL.h';

    public function SDL_Init(int $flags): int
    {
        return $this->ffi->SDL_Init($flags);
    }

    public function SDL_GetError(): string
    {
        return (string)$this->ffi->SDL_GetError();
    }

    public function SDL_CreateWindow(string $title, int $x, int $y, int $width, int $height, int $flags): ?SDLWindow
    {
        $window = $this->ffi->SDL_CreateWindow($title, $x, $y, $width, $height, $flags);
        if (!$window) {
            return null;
        }

        return new SDLWindow($window);
    }

    public function SDL_DestroyWindow(SDLWindow $window): void
    {
        $this->ffi->SDL_DestroyWindow($window->getSdlWindow());
    }

    public function SDL_CreateRenderer(SDLWindow $window, int $index, int $flags): ?SDLRenderer
    {
        $renderer = $this->ffi->SDL_CreateRenderer($window->getSdlWindow(), $index, $flags);
        if (!$renderer) {
            return null;
        }

        return new SDLRenderer($renderer);
    }

    public function SDL_UpdateWindowSurface(SDLWindow $window): int
    {
        return $this->ffi->SDL_UpdateWindowSurface($window->getSdlWindow());
    }

    public function SDL_DestroyRenderer(SDLRenderer $renderer): void
    {
        $this->ffi->SDL_DestroyRenderer($renderer->getSdlRenderer());
    }

    public function SDL_Quit(): void
    {
        $this->ffi->SDL_Quit();
    }

    public function SDL_Delay(int $ms): void
    {
        $this->ffi->SDL_Delay($ms);
    }

    public function SDL_CreateTextureFromSurface(SDLRenderer $renderer, $surfaceMessage)
    {
        $texture = $this->ffi->SDL_CreateTextureFromSurface($renderer->getSdlRenderer(), $surfaceMessage);
        if (!$texture || FFI::isNull($texture)) {
            return null;
        }

        return $texture;
    }

    public function SDL_FreeSurface($surfaceMessage): void
    {
        $this->ffi->SDL_FreeSurface($surfaceMessage);
    }

    public function SDL_DestroyTexture($texture): void
    {
        $this->ffi->SDL_DestroyTexture($texture);
    }

    public function SDL_PollEvent($windowEvent): int
    {
        return $this->ffi->SDL_PollEvent(FFI::addr($windowEvent));
    }

    public function createWindowEvent()
    {
        return $this->ffi->new('SDL_Event');
    }

    public function SDL_RWFromFile(string $filePath, string $mode)
    {
        return $this->ffi->SDL_RWFromFile($filePath, $mode);
    }


    public function SDL_SetRenderDrawColor(SDLRenderer $renderer, int $r, int $g, int $b, int $a): int
    {
        return $this->ffi->SDL_SetRenderDrawColor($renderer->getSdlRenderer(), $r, $g, $b, $a);
    }

    public function SDL_RenderFillRect(SDLRenderer $renderer, SDLRect $mainRect): int
    {
        $sdlRect = $this->ffi->new('SDL_Rect');
        $sdlRect->x = $mainRect->getX();
        $sdlRect->y = $mainRect->getY();
        $sdlRect->w = $mainRect->getWidth();
        $sdlRect->h = $mainRect->getHeight();

        $sdlRectPtr = FFI::addr($sdlRect);

        $result = $this->ffi->SDL_RenderFillRect($renderer->getSdlRenderer(), $sdlRectPtr);

        FFI::free($sdlRectPtr);

        return $result;
    }

    public function SDL_RenderPresent(SDLRenderer $renderer): void
    {
        $this->ffi->SDL_RenderPresent($renderer->getSdlRenderer());
    }

    public function SDL_RenderCopy(
        SDLRenderer $renderer,
        $texture,
        ?SDLRect $source = null,
        ?SDLRect $destination = null
    ): int {
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
            $renderer->getSdlRenderer(),
            $texture,
            $sourceRectPtr,
            $destinationRectPtr
        );

        if ($destinationRectPtr) {
            FFI::free($destinationRectPtr);
        }

        return $result;
    }

    public function SDL_RenderClear(SDLRenderer $renderer): int
    {
        return $this->ffi->SDL_RenderClear($renderer->getSdlRenderer());
    }
}
