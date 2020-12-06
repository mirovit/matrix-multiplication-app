<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\Http\Responses\SuccessResponse;
use App\Http\Responses\ValidationErrorResponse;
use App\Services\Formatters\NumberToLetter;
use App\Services\Matrix\IntMatrix;
use App\Services\Matrix\MatrixMultiplier;
use Illuminate\Http\Request;


class MultiplicationController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $columnDelimiter = $request->input('columnDelimiter', ',');
        $rowDelimiter = $request->input('rowDelimiter', ';');

        $matrixA = (new IntMatrix())
            ->setColumnDelimiter($columnDelimiter)
            ->setRowDelimiter($rowDelimiter)
            ->parse($request->input('matrixA'));

        $matrixB = (new IntMatrix())
            ->setColumnDelimiter($columnDelimiter)
            ->setRowDelimiter($rowDelimiter)
            ->parse($request->input('matrixB'));

        $matrixMultiplier = (new MatrixMultiplier($matrixA, $matrixB))
            ->validate();

        if (!$matrixMultiplier->isValid()) {
            return new ValidationErrorResponse($matrixMultiplier->getErrors());
        }

        $formatter = new NumberToLetter();
        $resultMatrix = $matrixMultiplier
            ->calculate()
            ->setOutputFormatter(
                function ($value) use ($formatter) {
                    return $formatter->format($value);
                }
            );

        return new SuccessResponse(
            [
                'matrix' => $resultMatrix->getRows(),
            ]
        );
    }
}
