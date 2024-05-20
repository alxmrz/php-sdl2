<?php

namespace SDL2;

use FFI;

class LibSDL2Image extends Library
{
    protected const string LIB_SDL_2_SO = 'libSDL2_image-2.0.so.0';
    protected const string PATH_TO_SDL2_HEADERS = __DIR__ . '/../resources/headers/SDL_image.h';

    public function IMG_Load(string $imagePath): ?FFI\CData
    {
        return $this->ffi->IMG_Load($imagePath);
    }
}