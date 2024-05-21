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

        if (SDLEvent::SDL_MOUSEBUTTONDOWN === $windowEvent->type) {
            if ($windowEvent->button->button === KeyCodes::SDL_BUTTON_LEFT) {
                printf("Pressed left mouse button\n");
                continue;
            }

            if ($windowEvent->button->button === KeyCodes::SDL_BUTTON_MIDDLE) {
                printf("Pressed middle mouse button\n");
                continue;
            }

            if ($windowEvent->button->button === KeyCodes::SDL_BUTTON_RIGHT) {
                printf("Pressed right mouse button\n");
                continue;
            }
        }

        if (SDLEvent::SDL_MOUSEBUTTONUP === $windowEvent->type) {
            if ($windowEvent->button->button === KeyCodes::SDL_BUTTON_LEFT) {
                printf("Released left mouse button\n");
                continue;
            }

            if ($windowEvent->button->button === KeyCodes::SDL_BUTTON_MIDDLE) {
                printf("Released middle mouse button\n");
                continue;
            }

            if ($windowEvent->button->button === KeyCodes::SDL_BUTTON_RIGHT) {
                printf("Released right mouse button\n");
                continue;
            }
        }

        if (SDLEvent::SDL_MOUSEMOTION === $windowEvent->type) {
            printf("X: %d, Y: %d\n", $windowEvent->motion->x, $windowEvent->motion->y);
            continue;
        }

        if (SDLEvent::SDL_MOUSEWHEEL === $windowEvent->type) {
            printf("Mouse wheel offsest for y: %d\n", $windowEvent->wheel->y);
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