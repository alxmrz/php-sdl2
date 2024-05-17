<?php
// /usr/lib/x86_64-linux-gnu/libSDL2.so

//cpp -P /usr/include/unprocessedheader.h -o myprettyheader.h
//ini_set("ffi.enable", true);

const SDL_INIT_EVERYTHING = ( 0x00000001 | 0x00000010 | 0x00000020 | 0x00004000 | 0x00000200 | 0x00001000 | 0x00002000 | 0x00008000 );

$sdl = FFI::cdef(<<<C
   typedef uint32_t Uint32;
   typedef struct SDL_Window SDL_Window;
   struct SDL_Renderer;
   typedef struct SDL_Renderer SDL_Renderer;
   typedef uint8_t Uint8;
   
   typedef struct SDL_Rect
    {
        int x, y;
        int w, h;
    } SDL_Rect;
    
   int SDL_Init(Uint32 flags);
   const char * SDL_GetError(void);
   SDL_Window * SDL_CreateWindow(const char *title,
                                                      int x, int y, int w,
                                                      int h, Uint32 flags);
   SDL_Renderer * SDL_CreateRenderer(SDL_Window * window,
                                               int index, Uint32 flags);      
   int SDL_UpdateWindowSurface(SDL_Window * window);         
   
   int SDL_SetRenderDrawColor(SDL_Renderer * renderer,
                                           Uint8 r, Uint8 g, Uint8 b,
                                           Uint8 a);
    int SDL_RenderFillRect(SDL_Renderer * renderer,
                                               const SDL_Rect * rect);
                                                                                      
    void SDL_RenderPresent(SDL_Renderer * renderer);                                        
    void SDL_DestroyRenderer(SDL_Renderer * renderer);   
    void SDL_Quit(void);     
    void SDL_DestroyWindow(SDL_Window * window);           
    
    void SDL_Delay(Uint32 ms);             
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