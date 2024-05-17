<?php
// /usr/lib/x86_64-linux-gnu/libSDL2.so

//cpp -P /usr/include/unprocessedheader.h -o myprettyheader.h
//ini_set("ffi.enable", true);

const SDL_INIT_EVERYTHING = ( 0x00000001 | 0x00000010 | 0x00000020 | 0x00004000 | 0x00000200 | 0x00001000 | 0x00002000 | 0x00008000 );

$sdl = FFI::cdef(<<<C
              
C
, 'libSDL2.so');

var_dump($sdl);

if ($sdl->SDL_Init(SDL_INIT_EVERYTHING) !== 0) {
    echo "ERROR ON INIT: " . $sdl->SDL_GetError();
}

$window = $sdl->SDL_CreateWindow(
    "Tetris with SDL2!",
    100,
    100,
    800,
    600,
    4);

$renderer = $sdl->SDL_CreateRenderer($window, -1, 2);
if ($renderer == NULL) {
    echo "ERROR ON INIT: " . $sdl->SDL_GetError();

    return;
}

$sdl->SDL_UpdateWindowSurface($window);
$sdl->SDL_SetRenderDrawColor($renderer, 160, 160, 160, 0);

$mainRect = $sdl->new('SDL_Rect');

$mainRect->x = 0;
$mainRect->y = 0;
$mainRect->w = 800;
$mainRect->h = 600;

var_dump($mainRect);

$mainRectPtr = FFI::addr($mainRect);

if ($sdl->SDL_RenderFillRect($renderer, $mainRectPtr) < 0) {
    echo "ERROR ON INIT: " . $sdl->SDL_GetError();
    $sdl->SDL_DestroyRenderer($renderer);
    $sdl->SDL_Quit();
    $sdl->SDL_DestroyWindow($window);
}
FFI::free($mainRectPtr);
$sdl->SDL_RenderPresent($renderer);
$sdl->SDL_Delay(5000);

$sdl->SDL_DestroyRenderer($renderer);
$sdl->SDL_Quit();
$sdl->SDL_DestroyWindow($window);