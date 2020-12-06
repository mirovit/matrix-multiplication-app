<?php


namespace App\Services\Matrix;

class IntMatrix extends Matrix
{
    public function __construct()
    {
        $valueFormatter = function ($value) {
            return (int)$value;
        };

        $this->setOutputFormatter($valueFormatter);
    }
}
