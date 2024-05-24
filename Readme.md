# PHP-SDL2

PHP FFI binding for SDL2 library

[<img src="./resources/logo_displayed.png" width="300" height="300" />](./resources/logo_displayed.png)

Steps to run example:
1) Check that extension FFI is enabled in your php settings (usually enabled by default)
2) Install SDL2 library (`libSDL2.so, libSDL2_image.so, libSDL2_mixer, libSDL2_ttf`)
3) Run `php examples/simple_window.php`. Window will be open if everything is correct.

Use can use the classes to call SDL2 functions:
- `LibSDL2` - functions of libSDL2.so. Docs - https://wiki.libsdl.org/SDL2/FrontPage
- `LibSDL2Image` - functions of libSDL2_image.so. Docs - https://wiki.libsdl.org/SDL2_image/FrontPage
- `LibSDL2Mixer` - functions of libSDL2_mixer.so Docs - https://wiki.libsdl.org/SDL2_mixer/FrontPage
- `LibSDL2TTF` - function of libSDL2_ttf. Docs - https://wiki.libsdl.org/SDL2_ttf/FrontPage

The classes' methods referer to original functions almost one-to-one except some structures used as wrappers.

Notes:
- Some C structs do not have class wrappers because of floating segfault cased when `FFI\CData` saved into private field.
- If a struct used in different header files it will be replaced with void, e.g. `SDL_Surface *` changed to `void *`.
- For now not all functions of mentioned libraries have their own wrappers.

Public API of the package is unstable and can be changed in any moment.

Warning! Sometimes the package causes a floating segfault in unknown situations.

Tested under Linux only.

Projects that used current package:
- https://github.com/alxmrz/deminer - analog of class Minesweeper 