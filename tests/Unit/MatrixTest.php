<?php

namespace Unit;

use App\Services\Matrix\Matrix;
use TestCase;

class MatrixTest extends TestCase
{
    /**
     * @test
     */
    public function it_sets_and_gets_rows()
    {
        $input = [
            [1, 2, 3],
            [4, 5, 6]
        ];

        $matrix = (new Matrix())->setRows($input);

        $this->assertSame($input, $matrix->getRows());
    }

    /**
     * @test
     */
    public function it_sets_and_gets_columns()
    {
        $input = [
            [1, 2, 3],
            [4, 5, 6]
        ];

        $output = [
            [1, 4],
            [2, 5],
            [3, 6]
        ];

        $matrix = (new Matrix())->setRows($input);

        $this->assertSame($output, $matrix->getColumns());
    }

    /**
     * @test
     */
    public function it_sets_and_gets_row_delimiter()
    {
        $delimiter = '~';

        $matrix = (new Matrix())->setRowDelimiter($delimiter);

        $this->assertSame($delimiter, $matrix->getRowDelimiter());
    }

    /**
     * @test
     */
    public function it_sets_and_gets_column_delimiter()
    {
        $delimiter = '`';

        $matrix = (new Matrix())->setColumnDelimiter($delimiter);

        $this->assertSame($delimiter, $matrix->getColumnDelimiter());
    }

    /**
     * @test
     */
    public function it_sets_and_gets_input_formatter()
    {
        $formatter = function () {
            return true;
        };

        $matrix = (new Matrix())->setInputFormatter($formatter);

        $this->assertSame($formatter, $matrix->getInputFormatter());
    }

    /**
     * @test
     */
    public function it_sets_and_gets_output_formatter()
    {
        $formatter = function () {
            return true;
        };

        $matrix = (new Matrix())->setOutputFormatter($formatter);

        $this->assertSame($formatter, $matrix->getOutputFormatter());
    }

    /**
     * @test
     */
    public function it_formats_input_values()
    {
        $input = 'a,b,c';
        $output = [
            [97, 98, 99]
        ];

        $formatter = function ($value) {
            return ord($value);
        };

        $matrix = (new Matrix())
            ->setInputFormatter($formatter)
            ->parse($input);

        $this->assertSame($output, $matrix->getRows());
    }

    /**
     * @test
     */
    public function it_formats_output_values()
    {
        $input = '97,98,99';
        $output = [
            ['a', 'b', 'c']
        ];

        $formatter = function ($value) {
            return chr((int)$value);
        };

        $matrix = (new Matrix())
            ->setOutputFormatter($formatter)
            ->parse($input);

        $this->assertSame($output, $matrix->getRows());
    }


    /**
     * @test
     */
    public function it_parses_string_into_matrix()
    {
        $input = '1,2,3;4,5,6';
        $output = [
            ['1', '2', '3'],
            ['4', '5', '6']
        ];

        $matrix = (new Matrix())->parse($input);

        $this->assertSame($output, $matrix->getRows());
    }

    /**
     * @test
     */
    public function it_can_accept_different_row_delimiter()
    {
        $input = '1,2,3^4,5,6';
        $output = [
            ['1', '2', '3'],
            ['4', '5', '6']
        ];

        $matrix = (new Matrix())
            ->setRowDelimiter('^')
            ->parse($input);

        $this->assertSame($output, $matrix->getRows());
    }

    /**
     * @test
     */
    public function it_can_accept_different_column_delimiter()
    {
        $input = '1/2/3;4/5/6';
        $output = [
            ['1', '2', '3'],
            ['4', '5', '6']
        ];

        $matrix = (new Matrix())
            ->setColumnDelimiter('/')
            ->parse($input);

        $this->assertSame($output, $matrix->getRows());
    }

    /**
     * @test
     */
    public function it_counts_columns()
    {
        $input = '1,2,3';

        $matrix = (new Matrix())->parse($input);

        $this->assertSame(3, $matrix->getColumnsCount());
    }

    /**
     * @test
     */
    public function it_counts_rows()
    {
        $input = '1,2,3';

        $matrix = (new Matrix())->parse($input);

        $this->assertSame(1, $matrix->getRowsCount());
    }

    /**
     * @test
     */
    public function it_validates_columns_are_of_equal_size()
    {
        $input = '1,2,3;4,5,6,7';

        $matrix = (new Matrix())->parse($input);

        $this->assertFalse($matrix->isValid());
    }

    /**
     * @test
     */
    public function it_converts_a_matrix_to_string()
    {
        $input = [
            [1, 2, 3],
            [4, 5, 6]
        ];

        $output = '1,2,3;4,5,6';

        $matrix = (new Matrix())->setRows($input);

        $this->assertSame($output, (string)$matrix);
    }
}
