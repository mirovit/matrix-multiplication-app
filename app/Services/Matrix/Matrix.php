<?php


namespace App\Services\Matrix;

use Closure;

class Matrix
{
    protected array $rows = [];
    protected array $columns = [];
    protected string $rowDelimiter = ';';
    protected string $columnDelimiter = ',';
    protected Closure|null $inputFormatter;
    protected Closure|null $outputFormatter;

    public function setRows(array $rows): Matrix
    {
        if (isset($this->inputFormatter)) {
            foreach ($rows as $key => $row) {
                $rows[$key] = array_map($this->getInputFormatter(), $row);
            }
        }

        $this->rows = $rows;

        return $this->setColumns();
    }

    public function getRows(): array
    {
        if (!isset($this->outputFormatter)) {
            return $this->rows;
        }

        $rows = $this->rows;

        foreach ($rows as $key => $row) {
            $rows[$key] = array_map($this->getOutputFormatter(), $row);
        }

        return $rows;
    }

    public function setColumns(): Matrix
    {
        $columns = array_fill(0, $this->getColumnsCount(), []);
        foreach ($this->getRows() as $rows) {
            foreach ($rows as $index => $value) {
                $columns[$index][] = $value;
            }
        }
        $this->columns = $columns;

        return $this;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function setRowDelimiter(string $rowDelimiter): Matrix
    {
        $this->rowDelimiter = $rowDelimiter;
        return $this;
    }

    public function getRowDelimiter(): string
    {
        return $this->rowDelimiter;
    }

    public function setColumnDelimiter(string $columnDelimiter): Matrix
    {
        $this->columnDelimiter = $columnDelimiter;
        return $this;
    }

    public function getColumnDelimiter(): string
    {
        return $this->columnDelimiter;
    }

    public function setInputFormatter(Closure|null $inputFormatter): Matrix
    {
        $this->inputFormatter = $inputFormatter;
        return $this;
    }

    public function getInputFormatter(): ?Closure
    {
        return $this->inputFormatter;
    }

    public function setOutputFormatter(Closure|null $outputFormatter): Matrix
    {
        $this->outputFormatter = $outputFormatter;
        return $this;
    }

    public function getOutputFormatter(): Closure|null
    {
        return $this->outputFormatter;
    }

    public function parse(string $matrix): Matrix
    {
        $this->setRows(
            array_map(
                function (string $row) {
                    return explode($this->columnDelimiter, $row);
                },
                explode($this->rowDelimiter, $matrix)
            )
        );

        return $this;
    }

    public function getColumnsCount(): int
    {
        return count(current($this->getRows()));
    }

    public function getRowsCount(): int
    {
        return count($this->getRows());
    }

    public function isValid(): bool
    {
        if (empty($this->getRows())) {
            return false;
        }

        $columnsCount = $this->getColumnsCount();

        foreach ($this->getRows() as $row) {
            if (count($row) !== $columnsCount) {
                return false;
            }
        }

        return true;
    }

    public function __toString(): string
    {
        $output = [];

        foreach ($this->getRows() as $row) {
            $output[] = implode($this->columnDelimiter, $row);
        }

        return implode($this->rowDelimiter, $output);
    }
}
