<?php

namespace SDL2;

use FFI\CData;

class SDLRect
{
    private int $x;
    private int $y;
    private int $width;
    private int $height;

    private CData $sdlRect;

    /**
     * @param CData $sdlRect
     */
    public function __construct(CData $sdlRect)
    {
        $this->sdlRect = $sdlRect;
    }

    /**
     * @return CData
     */
    public function getSdlRect(): CData
    {
        return $this->sdlRect;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth(int $width): void
    {
        $this->sdlRect->w = $width;
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height): void
    {
        $this->sdlRect->h = $height;
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     */
    public function setY(int $y): void
    {
        $this->sdlRect->y = $y;
        $this->y = $y;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     */
    public function setX(int $x): void
    {
        $this->sdlRect->x = $x;
        $this->x = $x;
    }


}