<?php

namespace SDL2;

use Exception;
use FFI;

class TTF
{
    private const LIB_SDL_TTF_2_SO = 'libSDL2_ttf.so';
    private const PATH_TO_SDL2_TTF_HEADERS = __DIR__ . '/../resources/headers/SDL_ttf.h';
    private $ffi;

    public function __construct($ffi)
    {

        $this->ffi = $ffi;
    }

    /**
     * Load library SDL2 via FFI
     *
     * @param string $libSOPath specify path to library SDL2 if it saved in not standard directory
     * @return static
     * @throws Exception
     */
    public static function load(string $libSOPath = ''): static
    {
        $headers = file_get_contents(self::PATH_TO_SDL2_TTF_HEADERS);
        if (!$headers) {
            throw new Exception('Not found SDL headers!');
        }

        return new static(FFI::cdef($headers, $libSOPath ?: self::LIB_SDL_TTF_2_SO));
    }

    public function openFont(string $pathToFont, int $ptSize): ?TTFFont
    {
        $ttfFont = $this->ffi->TTF_OpenFont($pathToFont, $ptSize);
        if (!$ttfFont || FFI::isNull($ttfFont)) {
            return null;
        }

        return new TTFFont($ttfFont);
    }

    public function init(): int
    {
        return $this->ffi->TTF_Init();
    }

    public function quit(): void
    {
        $this->ffi->TTF_Quit();
    }

    public function renderTextSolid(TTFFont $sans, string $message, SDLColor $color)
    {
        $sdlColor = $this->ffi->new("struct SDL_Color", false);
        $sdlColor->r = $color->r;
        $sdlColor->g = $color->g;
        $sdlColor->b = $color->b;
        $sdlColor->a = $color->a;

        $surface = $this->ffi->TTF_RenderText_Solid($sans->getTTFFont(), $message, $sdlColor);
        FFI::free($sdlColor);
        if (!$surface) {
            return null;
        }

        if (FFI::isNull($surface)) {
            echo "FFI Surface is NULL pointer\n";

            return null;
        }

        return $surface;
    }

    public function closeFont(TTFFont $sans): void
    {
        $this->ffi->TTF_CloseFont($sans->getTTFFont());
    }
}