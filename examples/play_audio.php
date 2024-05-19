<?php

use SDL2\SDL;
use SDL2\SDLMixer;
use SDL2\SDLRect;

require_once __DIR__ . '/../vendor/autoload.php';

$sdl = SDL::load();

if ($sdl->init(SDL::INIT_EVERYTHING) !== 0) {
    echo "ERROR ON INIT: " . $sdl->getError();

    exit();
}

$mixer = SDLMixer::load();

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

$mixDefaultFormat = 0x8010;

if ($mixer->openAudio(44100, $mixDefaultFormat, 2,2048) < 0) {
    printf("ERROR ON open audio: " . $sdl->getError());

    $window->destroyRenderer($renderer);
    $sdl->destroyWindow($window);
    $sdl->quit();
}

$backMusic = $mixer->Mix_LoadMUS(__DIR__ . '/background.mp3');
$mixer->playMusic($backMusic, -1);

$sdl->delay(2000);

$chunk = $mixer->loadWAV(__DIR__ . '/chunk.mp3', $sdl);
$mixer->playChannel(-1, $chunk, 0);

$sdl->delay(3000);

$window->destroyRenderer($renderer);
$sdl->destroyWindow($window);
$sdl->quit();