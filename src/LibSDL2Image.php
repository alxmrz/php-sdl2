<?php

namespace SDL2;

use FFI;

class LibSDL2Image extends Library
{
    protected const string LIB_SHARED_BINARY_FILE = 'libSDL2_image-2.0.so.0';
    protected const string PATH_TO_LIBRARY_HEADERS = __DIR__ . '/headers/SDL_image.h';
    protected static $lib = null;

    public function IMG_Load(string $imagePath): ?FFI\CData
    {
        return $this->ffi->IMG_Load($imagePath);
    }
}