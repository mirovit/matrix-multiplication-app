<?php

namespace Unit;

use App\Services\Matrix\IntMatrix;
use App\Services\Matrix\MatrixMultiplier;
use TestCase;

class MatrixMultiplierTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_no_errors_before_validation()
    {
        $matrixA = '1,2;3,4';
        $matrixB = '1;2;3';

        $matrixMultiplier = new MatrixMultiplier(
            (new IntMatrix())->parse($matrixA),
            (new IntMatrix())->parse($matrixB)
        );

        $this->assertCount(0, $matrixMultiplier->getErrors());

        $matrixMultiplier->validate();

        $this->assertCount(1, $matrixMultiplier->getErrors());
    }

    /**
     * @test
     */
    public function it_validates_input()
    {
        $matrixA = '1,2;3,4';
        $matrixB = '1;2';

        $matrixMultiplier = new MatrixMultiplier(
            (new IntMatrix())->parse($matrixA),
            (new IntMatrix())->parse($matrixB)
        );

        $matrixMultiplier->validate();

        $this->assertTrue($matrixMultiplier->isValid());
    }

    /**
     * @test
     */
    public function it_detects_unequal_matrices()
    {
        $matrixA = '1,2;3,4';
        $matrixB = '1;2;3';

        $matrixMultiplier = new MatrixMultiplier(
            (new IntMatrix())->parse($matrixA),
            (new IntMatrix())->parse($matrixB)
        );

        $matrixMultiplier->validate();

        $this->assertFalse($matrixMultiplier->isValid());
        $this->assertCount(1, $matrixMultiplier->getErrors());
    }

    /**
     * @test
     */
    public function it_calculates_matrix()
    {
        $matrixA = '1,2,3;4,5,6';
        $matrixB = '1,2,3;1,2,3;1,2,3';

        $matrixMultiplier = new MatrixMultiplier(
            (new IntMatrix())->parse($matrixA),
            (new IntMatrix())->parse($matrixB)
        );

        $outputMatrix = [
            [6, 12, 18],
            [15, 30, 45]
        ];

        $this->assertSame($outputMatrix, $matrixMultiplier->calculate()->getRows());
    }
}
