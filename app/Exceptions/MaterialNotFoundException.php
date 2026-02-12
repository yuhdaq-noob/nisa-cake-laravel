<?php

namespace App\Exceptions;

use Exception;

class MaterialNotFoundException extends Exception
{
    public function __construct(?int $materialId = null)
    {
        $message = $materialId
            ? "Bahan baku dengan ID {$materialId} tidak ditemukan."
            : 'Data bahan baku tidak ditemukan di sistem.';

        parent::__construct($message);
    }
}
