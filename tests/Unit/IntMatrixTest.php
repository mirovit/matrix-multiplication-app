<?php


namespace Unit;

use App\Services\Matrix\IntMatrix;
use TestCase;

class IntMatrixTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_integer_matrix()
    {
        $input = '1,2,3';
        $output = [
            [1, 2, 3]
        ];

        $matrix = (new IntMatrix())->parse($input);

        $this->assertSame($output, $matrix->getRows());
    }
}
