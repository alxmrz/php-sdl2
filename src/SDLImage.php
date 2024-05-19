<?php

namespace SDL2;

use FFI;

class SDLImage
{
    private const LIB_SDL_2_SO = 'libSDL2_image-2.0.so.0';
    private const PATH_TO_SDL2_HEADERS = __DIR__ . '/../resources/headers/SDL_image.h';
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
     * @throws Exception
     */
    public static function load(string $libSOPath = ''): static
    {
        $headers = file_get_contents(self::PATH_TO_SDL2_HEADERS);
        if (!$headers) {
            throw new Exception('Not found SDL image headers!');
        }

        return new static(FFI::cdef($headers, $libSOPath ?: self::LIB_SDL_2_SO));
    }

    public function loadImage(string $imagePath): ?FFI\CData
    {
        return $this->ffi->IMG_Load($imagePath);
    }
}