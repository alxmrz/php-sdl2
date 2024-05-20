<?php

/**
 * Example of event handling
 * You can close window and see handling of arrow keys here and any other key
 */


use SDL2\SDLEvent;
use SDL2\KeyCodes;
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

$isRunning = true;

while ($isRunning) {
    $windowEvent = $sdl->createWindowEvent();
    while ($sdl->SDL_PollEvent($windowEvent)) {
        if (SDLEvent::SDL_QUIT === $windowEvent->type) {
            printf("Pressed quit button\n");
            $isRunning = false;
            continue;
        }

        if (SDLEvent::SDL_KEYDOWN == $windowEvent->type) {
            switch ($windowEvent->key->keysym->sym) {
                case KeyCodes::SDLK_LEFT:
                    printf("Pressed left arrow key\n");
                    break;
                case KeyCodes::SDLK_RIGHT:
                    printf("Pressed right arrow key\n");
                    break;
                case KeyCodes::SDLK_UP:
                    printf("Pressed up arrow key\n");
                    break;
                case KeyCodes::SDLK_DOWN:
                    printf("Pressed down arrow key\n");
                    break;
                case KeyCodes::SDLK_SPACE:
                    printf("Pressed space\n");
                    break;
                default:
                    printf("Unknown key type %d\n", $windowEvent->key->keysym->sym);
                    break;
            }
        }
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

    $sdl->SDL_Delay(10);
}

$sdl->SDL_DestroyRenderer($renderer);
$sdl->SDL_DestroyWindow($window);
$sdl->SDL_Quit();