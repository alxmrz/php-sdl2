<?php

use SDL2\SDLImage;
use SDL2\LibSDL2;
use SDL2\SDLColor;
use SDL2\SDLRect;
use SDL2\TTF;

require_once __DIR__ . '/../vendor/autoload.php';

$sdl = LibSDL2::load();
if ($sdl->init(LibSDL2::INIT_EVERYTHING) !== 0) {
    echo "ERROR ON SDL INIT: " . $sdl->getError();

    exit();
}

$imager = SDLImage::load();

$window = $sdl->createWindow("PHP FFI and SDL2", 100, 100, 300, 300, 4);

$renderer = $window->createRenderer(-1, 2);
if ($renderer === NULL) {
    echo "ERROR ON INIT: " . $sdl->getError();

    $sdl->destroyWindow($window);
    $sdl->quit();

    exit();
}

if ($renderer->clear() < 0) {
    printf("Cant clear renderer: %s\n", $sdl->getError());

    $window->destroyRenderer($renderer);
    $sdl->destroyWindow($window);

    $sdl->quit();

    exit();
}

if ($renderer->setDrawColor(160, 160, 160, 0) < 0) {
    printf("Cant setDrawColor: %s\n", $sdl->getError());

    $window->destroyRenderer($renderer);
    $sdl->destroyWindow($window);

    $sdl->quit();

    exit();
}

$mainRect = new SDLRect(0, 0, 300, 300);

if ($renderer->fillRect($mainRect) < 0) {
    echo "ERROR ON INIT: " . $sdl->getError();
    $window->destroyRenderer($renderer);
    $sdl->destroyWindow($window);
    $sdl->quit();
    exit();
}

$color = new SDLColor(255, 0, 0, 0);

//SDL_Surface * image = SDL_LoadBMP("image.bmp");
$image = $imager->loadImage(__DIR__ . "/php_logo.png");
if ($image === null) {
    printf("Can't open image: %s\n", $sdl->getError());
    $window->destroyRenderer($renderer);
    $sdl->destroyWindow($window);
    $sdl->quit();

    exit();
}

$textureMessage = $sdl->createTextureFromSurface($renderer, $image);
if (!$textureMessage) {
    printf("Can't create texture: %s\n", $sdl->getError());
    $sdl->freeSurface($image);

    $sdl->quit();

    exit();
}

$messageRect = new SDLRect(50, 100, 200, 106);

if ($renderer->copy($textureMessage, null, $messageRect) !== 0) {

    printf("Error on copy: %s\n", $sdl->getError());

    $sdl->freeSurface($image);
    $sdl->quit();

    exit();
}

if (!empty($sdl->getError())) {
    printf("Unhandled error: %s\n", $sdl->getError());

    $sdl->freeSurface($image);
    $sdl->quit();

    exit();
}

$sdl->destroyTexture($textureMessage);
$sdl->freeSurface($image);

$renderer->present();

$sdl->delay(3000);

$window->destroyRenderer($renderer);
$sdl->destroyWindow($window);
$sdl->quit();