<?php

namespace SDL2;

class PixelBuffer
{
    private $pixBuffer;
    private int $length;

    public function __construct(int $length)
    {
        $this->length = $length;
        $this->pixBuffer = LibSDL2::load()->newArray($length);
    }

    public function add(int $index, int $pixel): void
    {
        $this->pixBuffer[$index] = $pixel;
    }

    public function fillWith(int $value): void
    {
        LibSDL2::load()->fillDataWithValue($this->pixBuffer, $value, $this->length*4);
    }

    public function getValue()
    {
        return $this->pixBuffer;
    }

    public function getLength(): int
    {
        return $this->length;
    }
}