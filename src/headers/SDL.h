typedef uint8_t Uint8;
typedef uint16_t Uint16;
typedef uint32_t Uint32;
typedef int32_t Sint32;


typedef struct SDL_Window SDL_Window;
struct SDL_Renderer;
typedef struct SDL_Renderer SDL_Renderer;

struct SDL_Texture;
typedef struct SDL_Texture SDL_Texture;
typedef struct SDL_RWops SDL_RWops;

typedef enum SDL_RendererFlip
{
    SDL_FLIP_NONE = 0x00000000,     /**< Do not flip */
    SDL_FLIP_HORIZONTAL = 0x00000001,    /**< flip horizontally */
    SDL_FLIP_VERTICAL = 0x00000002     /**< flip vertically */
} SDL_RendererFlip;

typedef struct SDL_Point
{
    int x;
    int y;
} SDL_Point;

typedef struct SDL_Rect
{
    int x, y;
    int w, h;
} SDL_Rect;


typedef struct SDL_Color
{
    Uint8 r;
    Uint8 g;
    Uint8 b;
    Uint8 a;
} SDL_Color;
typedef enum SDL_Scancode {
    SDL_SCANCODE_UNKNOWN = 0,
} SDL_Scancode;
typedef Sint32 SDL_Keycode;

typedef struct SDL_Keysym
{
    SDL_Scancode scancode;      /**< SDL physical key code - see ::SDL_Scancode for details */
    SDL_Keycode sym;            /**< SDL virtual key code - see ::SDL_Keycode for details */
    Uint16 mod;                 /**< current key modifiers */
    Uint32 unused;
} SDL_Keysym;

typedef struct SDL_KeyboardEvent
{
    Uint32 type;        /**< ::SDL_KEYDOWN or ::SDL_KEYUP */
    Uint32 timestamp;   /**< In milliseconds, populated using SDL_GetTicks() */
    Uint32 windowID;    /**< The window with keyboard focus, if any */
    Uint8 state;        /**< ::SDL_PRESSED or ::SDL_RELEASED */
    Uint8 repeat;       /**< Non-zero if this is a key repeat */
    Uint8 padding2;
    Uint8 padding3;
    SDL_Keysym keysym;  /**< The key that was pressed or released */
} SDL_KeyboardEvent;


typedef struct SDL_MouseMotionEvent
{
    Uint32 type;        /**< ::SDL_MOUSEMOTION */
    Uint32 timestamp;   /**< In milliseconds, populated using SDL_GetTicks() */
    Uint32 windowID;    /**< The window with mouse focus, if any */
    Uint32 which;       /**< The mouse instance id, or SDL_TOUCH_MOUSEID */
    Uint32 state;       /**< The current button state */
    Sint32 x;           /**< X coordinate, relative to window */
    Sint32 y;           /**< Y coordinate, relative to window */
    Sint32 xrel;        /**< The relative motion in the X direction */
    Sint32 yrel;        /**< The relative motion in the Y direction */
} SDL_MouseMotionEvent;

typedef struct SDL_MouseButtonEvent
{
    Uint32 type;        /**< ::SDL_MOUSEBUTTONDOWN or ::SDL_MOUSEBUTTONUP */
    Uint32 timestamp;   /**< In milliseconds, populated using SDL_GetTicks() */
    Uint32 windowID;    /**< The window with mouse focus, if any */
    Uint32 which;       /**< The mouse instance id, or SDL_TOUCH_MOUSEID */
    Uint8 button;       /**< The mouse button index */
    Uint8 state;        /**< ::SDL_PRESSED or ::SDL_RELEASED */
    Uint8 clicks;       /**< 1 for single-click, 2 for double-click, etc. */
    Uint8 padding1;
    Sint32 x;           /**< X coordinate, relative to window */
    Sint32 y;           /**< Y coordinate, relative to window */
} SDL_MouseButtonEvent;

typedef struct SDL_MouseWheelEvent
{
    Uint32 type;        /**< ::SDL_MOUSEWHEEL */
    Uint32 timestamp;   /**< In milliseconds, populated using SDL_GetTicks() */
    Uint32 windowID;    /**< The window with mouse focus, if any */
    Uint32 which;       /**< The mouse instance id, or SDL_TOUCH_MOUSEID */
    Sint32 x;           /**< The amount scrolled horizontally, positive to the right and negative to the left */
    Sint32 y;           /**< The amount scrolled vertically, positive away from the user and negative toward the user */
    Uint32 direction;   /**< Set to one of the SDL_MOUSEWHEEL_* defines. When FLIPPED the values in X and Y will be opposite. Multiply by -1 to change them back */
    float preciseX;     /**< The amount scrolled horizontally, positive to the right and negative to the left, with float precision (added in 2.0.18) */
    float preciseY;     /**< The amount scrolled vertically, positive away from the user and negative toward the user, with float precision (added in 2.0.18) */
} SDL_MouseWheelEvent;

typedef union SDL_Event {
        Uint32 type; /**< Event type, shared with all events */
        SDL_KeyboardEvent key;                  /**< Keyboard event data */
        SDL_MouseMotionEvent motion;            /**< Mouse motion event data */
        SDL_MouseButtonEvent button;            /**< Mouse button event data */
        SDL_MouseWheelEvent wheel;              /**< Mouse wheel event data */
        Uint8 padding[sizeof(void *) <= 8 ? 56 : sizeof(void *) == 16 ? 64 : 3 * sizeof(void *)];
} SDL_Event;

/*  FUNCTIONS  */
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

SDL_Texture * SDL_CreateTextureFromSurface(SDL_Renderer * renderer, void * surface);

void SDL_FreeSurface(void * surface);

int SDL_RenderCopy(SDL_Renderer * renderer,SDL_Texture * texture, const SDL_Rect * srcrect,const SDL_Rect * dstrect);

int SDL_RenderCopyEx(SDL_Renderer * renderer,
               SDL_Texture * texture,
               const SDL_Rect * srcrect,
               const SDL_Rect * dstrect,
               const double angle,
               const SDL_Point *center,
               const SDL_RendererFlip flip);

 void SDL_DestroyTexture(SDL_Texture * texture);

 void SDL_FreeSurface(void * surface);

 int SDL_RenderClear(SDL_Renderer * renderer);

int SDL_PollEvent(SDL_Event * event);

void * SDL_LoadBMP_RW(SDL_RWops * src, int freesrc);
void * SDL_RWFromFile(const char *file, const char *mode);
