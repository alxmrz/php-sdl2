<?php

use SDL2\LibSDL2;
use SDL2\SDLColor;
use SDL2\SDLRect;
use SDL2\TTF;

require_once __DIR__ . '/../vendor/autoload.php';

$sdl = LibSDL2::load();
if ($sdl->SDL_Init(LibSDL2::INIT_EVERYTHING) !== 0) {
    echo "ERROR ON SDL INIT: " . $sdl->SDL_GetError();

    exit();
}

$ttf = TTF::load();
if ($ttf->init() !== 0) {
    echo "ERROR ON TTF INIT: " . $sdl->SDL_GetError();

    exit();
}

$window = $sdl->SDL_CreateWindow("PHP FFI and SDL2", 100, 100, 800, 600, 4);

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

    $ttf->quit();
    $sdl->SDL_Quit();

    exit();
}

if ($sdl->SDL_SetRenderDrawColor($renderer, 160, 160, 160, 0) < 0) {
    printf("Cant setDrawColor: %s\n", $sdl->SDL_GetError());

    $sdl->SDL_DestroyRenderer($renderer);
    $sdl->SDL_DestroyWindow($window);

    $ttf->quit();
    $sdl->SDL_Quit();

    exit();
}

$mainRect = new SDLRect(0, 0, 800, 600);

if ($sdl->SDL_RenderFillRect($renderer, $mainRect) < 0) {
    echo "ERROR ON INIT: " . $sdl->SDL_GetError();
    $sdl->SDL_DestroyRenderer($renderer);
    $sdl->SDL_DestroyWindow($window);
    $sdl->SDL_Quit();
    exit();
}

$color = new SDLColor(255, 0, 0, 0);
$sans = $ttf->openFont(__DIR__ . '/Sans.ttf', 24);
if ($sans === null) {
    printf("Can't create font: %s\n", $sdl->SDL_GetError());
    $ttf->quit();
    $sdl->SDL_Quit();

    exit();
}

$surfaceMessage = $ttf->renderTextSolid($sans, "Hello, World!", $color);
if ($surfaceMessage === null) {
    printf("Can't create title surface: %s\n", $sdl->SDL_GetError());
    $ttf->closeFont($sans);
    $ttf->quit();
    $sdl->SDL_Quit();

    exit();
}
//$surface = new SDLSurface();
//$surface->setSdlSurface($surfaceMessage);

$textureMessage = $sdl->SDL_CreateTextureFromSurface($renderer, $surfaceMessage);
if (!$textureMessage) {
    printf("Can't create texture: %s\n", $sdl->SDL_GetError());
    $sdl->SDL_FreeSurface($surfaceMessage);
    $ttf->closeFont($sans);
    $ttf->quit();
    $sdl->SDL_Quit();

    exit();
}

$messageRect = new SDLRect(200, 150, 400, 100);

if ($sdl->SDL_RenderCopy($renderer, $textureMessage, null, $messageRect) !== 0) {
    printf("Error on copy: %s\n", $sdl->SDL_GetError());

    $sdl->SDL_FreeSurface($surfaceMessage);
    $ttf->closeFont($sans);
    $ttf->quit();
    $sdl->SDL_Quit();

    exit();
}

if (!empty($sdl->SDL_GetError())) {
    printf("Unhandled error: %s\n", $sdl->SDL_GetError());

    $sdl->SDL_FreeSurface($surfaceMessage);
    $ttf->closeFont($sans);
    $ttf->quit();
    $sdl->SDL_Quit();

    exit();
}

$ttf->closeFont($sans);
$sdl->SDL_DestroyTexture($textureMessage);
$sdl->SDL_FreeSurface($surfaceMessage);

$sdl->SDL_RenderPresent($renderer);

$sdl->SDL_Delay(3000);

$sdl->SDL_DestroyRenderer($renderer);
$sdl->SDL_DestroyWindow($window);
$ttf->quit();
$sdl->SDL_Quit();