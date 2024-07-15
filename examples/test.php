<?php

use SDL2\LibSDL2;
use SDL2\LibSDL2Mixer;

require_once __DIR__ . '/../vendor/autoload.php';


$sdl = LibSDL2::load();

if ($sdl->SDL_Init(LibSDL2::INIT_EVERYTHING) !== 0) {
    echo "ERROR ON INIT: " . $sdl->SDL_GetError();

    exit();
}

$mixer = LibSDL2Mixer::load();
if ($mixer->Mix_OpenAudio(44100, LibSDL2Mixer::DEFAULT_FORMAT, 2, 2048) === 0) {

} else {
    printf("ERROR ON open audio: %s\n", LibSDL2::load()->SDL_GetError());
}

$chunk = $mixer->Mix_LoadWAV(__DIR__ . '/../resources/chunk.mp3', LibSDL2::load());
$mixer->Mix_PlayChannel(-1, $chunk, 0);

$sdl->SDL_Delay(2000);

//$sdl->SDL_Quit();