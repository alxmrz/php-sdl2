<?php

use SDL2\LibSDL2;
use SDL2\SDLMixer;
use SDL2\SDLRect;

require_once __DIR__ . '/../vendor/autoload.php';

$sdl = LibSDL2::load();

if ($sdl->init(LibSDL2::INIT_EVERYTHING) !== 0) {
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

$renderer = $sdl->createRenderer($window, -1, 2);
if ($renderer === NULL) {
    echo "ERROR ON INIT: " . $sdl->getError();

    $sdl->destroyWindow($window);
    $sdl->quit();

    exit();
}

if ($sdl->clear($renderer) < 0) {
    printf("Cant clear renderer: %s\n", $sdl->getError());

    $sdl->destroyRenderer($renderer);
    $sdl->destroyWindow($window);

    $sdl->quit();

    exit();
}

$sdl->setDrawColor($renderer, 160, 160, 160, 0);

$mainRect = new SDLRect(0, 0, 800, 600);

$mainRect->setX(0);
$mainRect->setY(0);
$mainRect->setWidth(800);
$mainRect->setHeight(600);

if ($sdl->rendererfillRect($renderer, $mainRect) < 0) {
    echo "ERROR ON INIT: " . $sdl->getError();
    $sdl->destroyRenderer($renderer);
    $sdl->destroyWindow($window);
    $sdl->quit();
}

$sdl->rendererPresent($renderer, );

if ($mixer->openAudio(44100, SDLMixer::DEFAULT_FORMAT, 2,2048) < 0) {
    printf("ERROR ON open audio: " . $sdl->getError());

    $sdl->destroyRenderer($renderer);
    $sdl->destroyWindow($window);
    $sdl->quit();
}

$backMusic = $mixer->loadMus(__DIR__ . '/background.mp3');
$mixer->playMusic($backMusic, -1);

$sdl->delay(2000);

$chunk = $mixer->loadWAV(__DIR__ . '/chunk.mp3', $sdl);
$mixer->playChannel(-1, $chunk, 0);

$sdl->delay(3000);

$sdl->destroyRenderer($renderer);
$sdl->destroyWindow($window);
$sdl->quit();