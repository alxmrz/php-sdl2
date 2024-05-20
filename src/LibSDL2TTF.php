<?php

namespace SDL2;

use Exception;
use FFI;

class LibSDL2TTF extends Library
{
    protected const string LIB_SHARED_BINARY_FILE = 'libSDL2_ttf.so';
    protected const string PATH_TO_LIBRARY_HEADERS = __DIR__ . '/headers/SDL_ttf.h';

    public function TTF_OpenFont(string $pathToFont, int $ptSize)
    {
        $ttfFont = $this->ffi->TTF_OpenFont($pathToFont, $ptSize);
        if (!$ttfFont || FFI::isNull($ttfFont)) {
            return null;
        }

        return $ttfFont;
    }

    public function TTF_Init(): int
    {
        return $this->ffi->TTF_Init();
    }

    public function TTF_Quit(): void
    {
        $this->ffi->TTF_Quit();
    }

    public function TTF_RenderText_Solid($sans, string $message, SDLColor $color)
    {
        $sdlColor = $this->ffi->new("struct SDL_Color");
        $sdlColor->r = $color->r;
        $sdlColor->g = $color->g;
        $sdlColor->b = $color->b;
        $sdlColor->a = $color->a;

        $surface = $this->ffi->TTF_RenderText_Solid($sans, $message, $sdlColor);

        if (!$surface) {
            return null;
        }

        if (FFI::isNull($surface)) {
            echo "FFI Surface is NULL pointer\n";

            return null;
        }

        return $surface;
    }

    public function TTF_CloseFont($sans): void
    {
        $this->ffi->TTF_CloseFont($sans);
    }
}