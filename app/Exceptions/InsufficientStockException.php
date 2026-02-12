<?php

namespace App\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public function __construct(string $materialName, int $currentStock, int $requiredStock)
    {
        $this->message = "Stok Tidak Cukup! Bahan '{$materialName}' kurang. Stok: {$currentStock}, Butuh: {$requiredStock}.";
        parent::__construct($this->message);
    }
}
