<?php

use SDL2\SDL;
use SDL2\SDLRect;

require_once __DIR__ . '/../vendor/autoload.php';

$sdl = SDL::load();

if ($sdl->init(SDL::INIT_EVERYTHING) !== 0) {
    echo "ERROR ON INIT: " . $sdl->getError();

    exit();
}

$window = $sdl->createWindow(
    "PHP FFI and SDL2",
    100,
    100,
    400,
    400,
    4);

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

$renderer->setDrawColor(160, 160, 160, 0);

$mainRect = new SDLRect(0, 0, 800, 600);

$mainRect->setX(0);
$mainRect->setY(0);
$mainRect->setWidth(800);
$mainRect->setHeight(600);

if ($renderer->fillRect($mainRect) < 0) {
    echo "ERROR ON INIT: " . $sdl->getError();
    $window->destroyRenderer($renderer);
    $sdl->destroyWindow($window);
    $sdl->quit();
}

$renderer->present();

$sdl->delay(5000);

$window->destroyRenderer($renderer);
$sdl->destroyWindow($window);
$sdl->quit();