<?php

namespace SDL2;

use FFI;

class SDLMixer
{
    private const LIB_SDL_2_SO = 'libSDL2_mixer-2.0.so.0';
    private const PATH_TO_SDL2_HEADERS = __DIR__ . '/../resources/headers/SDL_mixer.h';
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
            throw new Exception('Not found SDL mixer headers!');
        }

        return new static(FFI::cdef($headers, $libSOPath ?: self::LIB_SDL_2_SO));
    }
    public function openAudio(int $frequency, int $format, int $channels, int $chunksize): int
    {
        return $this->ffi->Mix_OpenAudio($frequency, $format, $channels, $chunksize);
    }
//extern DECLSPEC Mix_Chunk * SDLCALL Mix_LoadWAV_RW(SDL_RWops *src, int freesrc);
//#define Mix_LoadWAV(file)   Mix_LoadWAV_RW(SDL_RWFromFile(file, "rb"), 1)
    public function loadWAV_new(string $filePath): ?FFI\CData
    {
        return $this->ffi->Mix_LoadWAV($filePath);
    }

    public function loadWAV(string $filePath, SDL $sdl): ?FFI\CData
    {
        return $this->ffi->Mix_LoadWAV_RW($sdl->rwFromFile($filePath, "rb"), 1);
    }

    public function Mix_LoadMUS(string $filePath): ?FFI\CData
    {
        return $this->ffi->Mix_LoadMUS($filePath);
    }

    /**
     * Play a new music object.
     *
     * @param $backMusic the new music object to schedule for mixing.
     * @param int $loops the number of loops to play the music for (0 means "play once and stop").
     * @return int
     */
    public function playMusic($backMusic, int $loops): int
    {
        return $this->ffi->Mix_PlayMusic($backMusic, $loops);
    }
    public function playChannel(int $channel, $chunk, $loops): int
    {
        return $this->ffi->Mix_PlayChannelTimed($channel, $chunk, $loops, -1);
    }
}