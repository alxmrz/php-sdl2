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

    protected const string LIB_SDL_2_SO = 'libSDL2.so';
    protected const string PATH_TO_SDL2_HEADERS = __DIR__ . '/../resources/headers/SDL.h';

    public function init(int $flags): int
    {
        return $this->ffi->SDL_Init($flags);
    }

    public function getError(): string
    {
        return (string)$this->ffi->SDL_GetError();
    }

    public function createWindow(string $title, int $x, int $y, int $width, int $height, int $flags): ?SDLWindow
    {
        $window = $this->ffi->SDL_CreateWindow($title, $x, $y, $width, $height, $flags);
        if (!$window) {
            return NULL;
        }

        return new SDLWindow($window, $this->ffi);
    }

    public function destroyWindow(SDLWindow $window): void
    {
        $this->ffi->SDL_DestroyWindow($window->getSdlWindow());

    }

    public function quit(): void
    {
        $this->ffi->SDL_Quit();
    }

    public function delay(int $ms): void
    {
        $this->ffi->SDL_Delay($ms);
    }

    public function createTextureFromSurface(SDLRenderer $renderer, $surfaceMessage)
    {
        $texture = $this->ffi->SDL_CreateTextureFromSurface($renderer->getSdlRenderer(), $surfaceMessage);
        if (!$texture || FFI::isNull($texture)) {
            return null;
        }

        return $texture;
    }

    public function freeSurface($surfaceMessage): void
    {
        $this->ffi->SDL_FreeSurface($surfaceMessage);
    }

    public function destroyTexture($texture): void
    {
        $this->ffi->SDL_DestroyTexture($texture);
    }

    public function pollEvent($windowEvent): int
    {
        return $this->ffi->SDL_PollEvent(FFI::addr($windowEvent));
    }

    public function createWindowEvent()
    {
        return $this->ffi->new('SDL_Event');
    }

    public function rwFromFile(string $filePath, string $mode)
    {
        return $this->ffi->SDL_RWFromFile($filePath, $mode);
    }
}