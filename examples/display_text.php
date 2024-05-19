<?php

use SDL2\SDL;
use SDL2\SDLColor;
use SDL2\SDLRect;
use SDL2\TTF;

require_once __DIR__ . '/../vendor/autoload.php';

$sdl = SDL::load();
if ($sdl->init(SDL::INIT_EVERYTHING) !== 0) {
    echo "ERROR ON SDL INIT: " . $sdl->getError();

    exit();
}

$ttf = TTF::load();
if ($ttf->init() !== 0) {
    echo "ERROR ON TTF INIT: " . $sdl->getError();

    exit();
}

$window = $sdl->createWindow("PHP FFI and SDL2", 100, 100, 800, 600, 4);

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

    $ttf->quit();
    $sdl->quit();

    exit();
}

if ($renderer->setDrawColor(160, 160, 160, 0) < 0) {
    printf("Cant setDrawColor: %s\n", $sdl->getError());

    $window->destroyRenderer($renderer);
    $sdl->destroyWindow($window);

    $ttf->quit();
    $sdl->quit();

    exit();
}

$mainRect = new SDLRect(0, 0, 800, 600);

if ($renderer->fillRect($mainRect) < 0) {
    echo "ERROR ON INIT: " . $sdl->getError();
    $window->destroyRenderer($renderer);
    $sdl->destroyWindow($window);
    $sdl->quit();
    exit();
}

$color = new SDLColor(255, 0, 0, 0);
$sans = $ttf->openFont(__DIR__ . '/Sans.ttf', 24);
if ($sans === null) {
    printf("Can't create font: %s\n", $sdl->getError());
    $ttf->quit();
    $sdl->quit();

    exit();
}

$surfaceMessage = $ttf->renderTextSolid($sans, "Hello, World!", $color);
if ($surfaceMessage === null) {
    printf("Can't create title surface: %s\n", $sdl->getError());
    $ttf->closeFont($sans);
    $ttf->quit();
    $sdl->quit();

    exit();
}
//$surface = new SDLSurface();
//$surface->setSdlSurface($surfaceMessage);

$textureMessage = $sdl->createTextureFromSurface($renderer, $surfaceMessage);
if (!$textureMessage) {
    printf("Can't create texture: %s\n", $sdl->getError());
    $sdl->freeSurface($surfaceMessage);
    $ttf->closeFont($sans);
    $ttf->quit();
    $sdl->quit();

    exit();
}

$messageRect = new SDLRect(200, 150, 400, 100);

if ($renderer->copy($textureMessage, null, $messageRect) !== 0) {

    printf("Error on copy: %s\n", $sdl->getError());

    $sdl->freeSurface($surfaceMessage);
    $ttf->closeFont($sans);
    $ttf->quit();
    $sdl->quit();

    exit();
}

if (!empty($sdl->getError())) {
    printf("Unhandled error: %s\n", $sdl->getError());

    $sdl->freeSurface($surfaceMessage);
    $ttf->closeFont($sans);
    $ttf->quit();
    $sdl->quit();

    exit();
}

$ttf->closeFont($sans);
$sdl->destroyTexture($textureMessage);
$sdl->freeSurface($surfaceMessage);

$renderer->present();

$sdl->delay(3000);

$window->destroyRenderer($renderer);
$sdl->destroyWindow($window);
$ttf->quit();
$sdl->quit();