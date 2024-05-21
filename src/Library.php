<?php

namespace SDL2;

use FFI;

abstract class Library
{
    protected const string LIB_SHARED_BINARY_FILE = '';
    protected const string PATH_TO_LIBRARY_HEADERS = '';

    protected FFI $ffi;

    protected static $lib = null;

    public function __construct(FFI $ffi)
    {
        $this->ffi = $ffi;
    }

    public static function load(string $libSOPath = ''): static
    {
        if (static::$lib === null) {
            $headers = file_get_contents(static::PATH_TO_LIBRARY_HEADERS);
            if (!$headers) {
                throw new Exception('Not found headers: ' . static::PATH_TO_LIBRARY_HEADERS);
            }

            static::$lib = new static(FFI::cdef($headers, $libSOPath ?: static::LIB_SHARED_BINARY_FILE));
        }

        return static::$lib;
    }
}