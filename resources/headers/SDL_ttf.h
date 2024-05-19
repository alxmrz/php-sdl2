typedef uint8_t Uint8;
typedef uint32_t Uint32;


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

typedef struct TTF_Font TTF_Font;
int TTF_Init(void);

TTF_Font * TTF_OpenFont(const char *file, int ptsize);

void TTF_Quit(void);

void * TTF_RenderText_Solid(TTF_Font *font, const char *text, SDL_Color fg);

void TTF_CloseFont(TTF_Font *font);