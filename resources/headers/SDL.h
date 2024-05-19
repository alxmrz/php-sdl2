typedef uint8_t Uint8;
typedef uint32_t Uint32;


typedef struct SDL_Window SDL_Window;
struct SDL_Renderer;
typedef struct SDL_Renderer SDL_Renderer;

struct SDL_Texture;
typedef struct SDL_Texture SDL_Texture;

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

 void SDL_DestroyTexture(SDL_Texture * texture);

 void SDL_FreeSurface(void * surface);

 int SDL_RenderClear(SDL_Renderer * renderer);