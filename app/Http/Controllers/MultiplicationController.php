<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\Http\Responses\SuccessResponse;
use App\Http\Responses\ValidationErrorResponse;
use App\Services\Formatters\NumberToLetter;
use App\Services\Matrix\IntMatrix;
use App\Services\Matrix\MatrixMultiplier;
use Closure;
use Illuminate\Http\Request;


class MultiplicationController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $columnDelimiter = $request->input('columnDelimiter', ',');
        $rowDelimiter = $request->input('rowDelimiter', ';');

        $matrixA = $this->parseMatrix($request->input('matrixA'), $rowDelimiter, $columnDelimiter);
        $matrixB = $this->parseMatrix($request->input('matrixB'), $rowDelimiter, $columnDelimiter);

        $matrixMultiplier = (new MatrixMultiplier($matrixA, $matrixB))
            ->validate();

        if (!$matrixMultiplier->isValid()) {
            return new ValidationErrorResponse($matrixMultiplier->getErrors());
        }

        return new SuccessResponse(
            [
                'matrix' => $matrixMultiplier
                    ->calculate()
                    ->setOutputFormatter($this->getOutputFormatter())
                    ->getRows(),
            ]
        );
    }

    private function parseMatrix(string $matrix, string $rowDelimiter, string $columnDelimiter): IntMatrix
    {
        return (new IntMatrix())
            ->setColumnDelimiter($columnDelimiter)
            ->setRowDelimiter($rowDelimiter)
            ->parse($matrix);
    }

    private function getOutputFormatter(): Closure
    {
        $formatter = new NumberToLetter();

        return function ($value) use ($formatter) {
            return $formatter->format($value);
        };
    }
}
