<?php


namespace App\Services\Matrix;

use JetBrains\PhpStorm\Pure;

class MatrixMultiplier
{
    protected array $errors = [];

    public function __construct(protected IntMatrix $matrixA, protected IntMatrix $matrixB)
    {
    }

    public function calculate(): Matrix
    {
        $matrix = [];

        foreach ($this->matrixA->getRows() as $rowIndex => $row) {
            $matrix[$rowIndex] = [];

            foreach ($this->matrixB->getColumns() as $colmnIndex => $column) {
                foreach ($column as $numberIndex => $number) {
                    $matrix[$rowIndex][$colmnIndex] = $this->calculateCell($row, $column);
                }
            }
        }

        return (new Matrix())
            ->setRowDelimiter($this->matrixA->getRowDelimiter())
            ->setColumnDelimiter($this->matrixA->getColumnDelimiter())
            ->setRows($matrix);
    }

    protected function calculateCell(array $row, array $column): int
    {
        $value = 0;

        foreach ($row as $index => $rowNumber) {
            $value += $rowNumber * $column[$index];
        }

        return $value;
    }

    public function validate(): MatrixMultiplier
    {
        if (!$this->matrixA->isValid()) {
            $this->errors[] = 'Matrix A is does not contain rows with equal count.';
        }

        if (!$this->matrixB->isValid()) {
            $this->errors[] = 'Matrix B is does not contain rows with equal count.';
        }

        $matrixAColumns = $this->matrixA->getColumnsCount();
        $matrixBRows = $this->matrixB->getRowsCount();

        if ($matrixAColumns !== $matrixBRows) {
            $this->errors[] = sprintf(
                'Matrix B should have %d rows to match the Matrix A columns. Matrix B contains %d rows.',
                $matrixAColumns,
                $matrixBRows
            );
        }

        return $this;
    }

    #[Pure] public function getErrors(): array
    {
        return $this->errors;
    }

    #[Pure] public function isValid(): bool
    {
        return count($this->errors) === 0;
    }
}
