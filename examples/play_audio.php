<?php

use SDL2\LibSDL2;
use SDL2\LibSDL2Mixer;
use SDL2\SDLRect;

require_once __DIR__ . '/../vendor/autoload.php';

$sdl = LibSDL2::load();

if ($sdl->SDL_Init(LibSDL2::INIT_EVERYTHING) !== 0) {
    echo "ERROR ON INIT: " . $sdl->SDL_GetError();

    exit();
}

$mixer = LibSDL2Mixer::load();

$window = $sdl->SDL_CreateWindow(
    "PHP FFI and SDL2",
    100,
    100,
    400,
    400,
    4
);

$renderer = $sdl->SDL_CreateRenderer($window, -1, 2);
if ($renderer === null) {
    echo "ERROR ON INIT: " . $sdl->SDL_GetError();

    $sdl->SDL_DestroyWindow($window);
    $sdl->SDL_Quit();

    exit();
}

if ($sdl->SDL_RenderClear($renderer) < 0) {
    printf("Cant clear renderer: %s\n", $sdl->SDL_GetError());

    $sdl->SDL_DestroyRenderer($renderer);
    $sdl->SDL_DestroyWindow($window);

    $sdl->SDL_Quit();

    exit();
}

$sdl->SDL_SetRenderDrawColor($renderer, 160, 160, 160, 0);

$mainRect = new SDLRect(0, 0, 800, 600);

$mainRect->setX(0);
$mainRect->setY(0);
$mainRect->setWidth(800);
$mainRect->setHeight(600);

if ($sdl->SDL_RenderFillRect($renderer, $mainRect) < 0) {
    echo "ERROR ON INIT: " . $sdl->SDL_GetError();
    $sdl->SDL_DestroyRenderer($renderer);
    $sdl->SDL_DestroyWindow($window);
    $sdl->SDL_Quit();
}

$sdl->SDL_RenderPresent($renderer);

if ($mixer->Mix_OpenAudio(44100, LibSDL2Mixer::DEFAULT_FORMAT, 2, 2048) < 0) {
    printf("ERROR ON open audio: " . $sdl->SDL_GetError());

    $sdl->SDL_DestroyRenderer($renderer);
    $sdl->SDL_DestroyWindow($window);
    $sdl->SDL_Quit();
}

$backMusic = $mixer->Mix_LoadMUS(__DIR__ . '/../resources/background.mp3');
$mixer->Mix_PlayMusic($backMusic, -1);

if ($mixer->Mix_PlayingMusic()) {
    printf("Music is playing \n");
}

$sdl->SDL_Delay(2000);
if ($mixer->Mix_PlayingMusic()) {
    printf("Music is not playing \n");
}

$chunk = $mixer->Mix_LoadWAV(__DIR__ . '/../resources/chunk.mp3', $sdl);
$mixer->Mix_PlayChannel(-1, $chunk, 0);

if ($mixer->Mix_PlayingMusic()) {
    printf("Music is playing again \n");
}
$sdl->SDL_Delay(3000);

$sdl->SDL_DestroyRenderer($renderer);
$sdl->SDL_DestroyWindow($window);
$sdl->SDL_Quit();