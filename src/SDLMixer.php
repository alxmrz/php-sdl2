<?php

namespace SDL2;

use FFI;
use FFI\CData;

class SDLMixer
{
    public const int DEFAULT_FORMAT = 0x8010;

    private const string LIB_SDL_2_SO = 'libSDL2_mixer-2.0.so.0';
    private const string PATH_TO_SDL2_HEADERS = __DIR__ . '/../resources/headers/SDL_mixer.h';
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

    /**
     * Mix_LoadWAV is a macros in SDL_Mixer 2.0, since 2.6 it became a function.
     * We use library 2.0 so we just fake the macros as is.
     *
     * For new lib version: $this->ffi->Mix_LoadWAV($filePath)
     *
     * @param string $filePath
     * @param LibSDL2 $sdl
     * @return ?CData
     */
    public function loadWAV(string $filePath, LibSDL2 $sdl): ?CData
    {
        return $this->ffi->Mix_LoadWAV_RW($sdl->rwFromFile($filePath, "rb"), 1);
    }

    public function loadMus(string $filePath): ?CData
    {
        return $this->ffi->Mix_LoadMUS($filePath);
    }

    /**
     * Play a new music object.
     *
     * @param CData $backMusic the new music object to schedule for mixing.
     * @param int $loops the number of loops to play the music for (0 means "play once and stop").
     * @return int
     */
    public function playMusic($backMusic, int $loops): int
    {
        return $this->ffi->Mix_PlayMusic($backMusic, $loops);
    }

    /**
     * Mix_PlayChannel is a macros for convenient call of Mix_PlayChannelTimed
     *
     * @param int $channel
     * @param CData $chunk
     * @param int $loops
     * @return int
     */
    public function playChannel(int $channel, $chunk, int $loops): int
    {
        return $this->ffi->Mix_PlayChannelTimed($channel, $chunk, $loops, -1);
    }
}