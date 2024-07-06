<?php

namespace SDL2;

enum SDLRendererFlip: int
{
    case SDL_FLIP_NONE = 0x00000000;    /**< Do not flip */
    case SDL_FLIP_HORIZONTAL = 0x00000001;    /**< flip horizontally */
    case SDL_FLIP_VERTICAL = 0x00000002;
}