<?php


namespace App\Services\Formatters;


class NumberToLetter
{
    public function format(int $value): string|null
    {
        $value = abs($value);

        if ($value === 0) {
            return null;
        }

        if ($value <= 26) {
            return chr(64 + $value);
        }

        $letter = chr(65 + (($value - 1) % 26));

        $value = ($value - 1) / 26;

        if ($value > 0) {
            return $this->format($value) . $letter;
        }

        return $letter;
    }
}
