<?php

namespace SDL2;

use FFI;
use FFI\CData;

class LibSDL2Mixer extends Library
{
    public const int DEFAULT_FORMAT = 0x8010;

    protected const string LIB_SHARED_BINARY_FILE = 'libSDL2_mixer-2.0.so.0';
    protected const string PATH_TO_LIBRARY_HEADERS = __DIR__ . '/headers/SDL_mixer.h';

    public function Mix_OpenAudio(int $frequency, int $format, int $channels, int $chunksize): int
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
    public function Mix_LoadWAV(string $filePath, LibSDL2 $sdl): ?CData
    {
        return $this->ffi->Mix_LoadWAV_RW($sdl->SDL_RWFromFile($filePath, "rb"), 1);
    }

    public function Mix_LoadMUS(string $filePath): ?CData
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
    public function Mix_PlayMusic($backMusic, int $loops): int
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
    public function Mix_PlayChannel(int $channel, $chunk, int $loops): int
    {
        return $this->ffi->Mix_PlayChannelTimed($channel, $chunk, $loops, -1);
    }
}