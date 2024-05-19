<?php

namespace SDL2;

class SDLColor
{
    public int $r;
    public int $g;
    public int $b;
    public int $a;

    /**
     * @param int $r
     * @param int $g
     * @param int $b
     * @param int $a
     */
    public function __construct(int $r, int $g, int $b, int $a)
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
        $this->a = $a;
    }
}