<?php

use SDL2\SDL;

require_once __DIR__ . '/../vendor/autoload.php';

$sdl = SDL::load();

if ($sdl->init(SDL::INIT_EVERYTHING) !== 0) {
    echo "ERROR ON INIT: " . $sdl->getError();

    exit();
}

$window = $sdl->createWindow(
    "Tetris with SDL2!",
    100,
    100,
    800,
    600,
    4);

$renderer = $window->createRenderer(-1, 2);
if ($renderer === NULL) {
    echo "ERROR ON INIT: " . $sdl->getError();

    $sdl->destroyWindow($window);
    $sdl->quit();

    exit();
}

$window->updateSurface();
$renderer->setDrawColor(160, 160, 160, 0);

$mainRect = $sdl->createRect(0, 0, 800, 600);

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