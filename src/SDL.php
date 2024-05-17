<?php

namespace SDL2;

use FFI;
use PHPUnit\Util\Exception;

class SDL
{
    public const INIT_EVERYTHING = (
        0x00000001 |
        0x00000010 |
        0x00000020 |
        0x00004000 |
        0x00000200 |
        0x00001000 |
        0x00002000 |
        0x00008000
    );


    private const LIB_SDL_2_SO = 'libSDL2.so';
    private const PATH_TO_SDL2_HEADERS = __DIR__ . '/../resources/headers/SDL.h';
    private FFI $ffi;

    public function __construct(FFI $ffi)
    {

        $this->ffi = $ffi;
    }

    /**
     * Load library SDL2 via FFI
     *
     * @param string $libSOPath specify path to library SDL2 if it saved in not standard directory
     * @return static
     */
    public static function load(string $libSOPath = ''): static
    {
        $headers = file_get_contents(self::PATH_TO_SDL2_HEADERS);
        if (!$headers) {
            throw new Exception('Not found SDL headers!');
        }

        return new static(FFI::cdef($headers, $libSOPath ?: self::LIB_SDL_2_SO));
    }

    public function init(int $flags): int
    {
        return $this->ffi->SDL_Init($flags);
    }

    public function getError(): string
    {
        return $this->ffi->SDL_GetError();
    }

    public function createWindow(string $title, int $x, int $y, int $width, int $height, int $flags): ?SDLWindow
    {
        $window = $this->ffi->SDL_CreateWindow($title, $x, $y, $width, $height, $flags);
        if (!$window) {
            return NULL;
        }

        return new SDLWindow($window, $this->ffi);
    }

    public function createRect(int $x = 0, int $y = 0, int $width = 0, int $height = 0): SDLRect
    {
        $rect = new SDLRect($this->ffi->new('SDL_Rect'));

        $rect->setX($x);
        $rect->setY($y);
        $rect->setWidth($width);
        $rect->setHeight($height);

        return $rect;
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
}