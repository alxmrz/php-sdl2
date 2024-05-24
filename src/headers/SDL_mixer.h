typedef uint8_t Uint8;
typedef uint16_t Uint16;
typedef uint32_t Uint32;

typedef struct Mix_Chunk {
    int allocated;
    Uint8 *abuf;
    Uint32 alen;
    Uint8 volume;       /* Per-sample volume, 0-128 */
} Mix_Chunk;
typedef struct _Mix_Music Mix_Music;

int Mix_OpenAudio(int frequency, Uint16 format, int channels, int chunksize);

Mix_Chunk * Mix_LoadWAV_RW(void *src, int freesrc);
Mix_Music * Mix_LoadMUS(const char *file);
int Mix_PlayMusic(Mix_Music *music, int loops);

int Mix_PlayChannelTimed(int channel, Mix_Chunk *chunk, int loops, int ticks);
