<?php

use SDL2\LibSDL2;
use SDL2\SDLRect;

require_once __DIR__ . '/../vendor/autoload.php';

$sdl = LibSDL2::load();

if ($sdl->SDL_Init(LibSDL2::INIT_EVERYTHING) !== 0) {
    echo "ERROR ON INIT: " . $sdl->SDL_GetError();

    exit();
}

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
$mainRect->setHeight(800);

if ($sdl->SDL_RenderFillRect($renderer, $mainRect) < 0) {
    echo "ERROR ON INIT: " . $sdl->SDL_GetError();
    $sdl->SDL_DestroyRenderer($renderer);
    $sdl->SDL_DestroyWindow($window);
    $sdl->SDL_Quit();
}

$sdl->SDL_SetRenderDrawColor($renderer, 255, 0, 0, 0);

for ($i = 0; $i < 800; $i++) {
    $sdl->SDL_RenderDrawPoint($renderer, $i, $i);
}

$sdl->SDL_RenderPresent($renderer);

$sdl->SDL_Delay(5000);

$sdl->SDL_DestroyRenderer($renderer);
$sdl->SDL_DestroyWindow($window);
$sdl->SDL_Quit();