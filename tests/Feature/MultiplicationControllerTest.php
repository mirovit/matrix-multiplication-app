<?php

namespace Feature;

use App\Http\Responses\Response;
use TestCase;

class MultiplicationControllerTest extends TestCase
{
    /**
     * @test
     */
    public function it_sends_validation_error_response()
    {
        $input = [
            'matrixA' => '1,2,3;3,2,1',
            'matrixB' => '12,24;54,15',
        ];

        $this->json('post', '/multiply', $input)
            ->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJson(
                [
                    'status' => 'error',
                    'error_code' => 'validation-error'
                ]
            );
    }

    /**
     * @test
     */
    public function it_retuns_calculated_matrix()
    {
        $input = [
            'matrixA' => '1,2,3;3,2,1',
            'matrixB' => '1,1,2;3,5,8;13,21,34',
        ];

        $this->json('post', '/multiply', $input)
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJson(
                [
                    'status' => 'success',
                    'data' => [
                        'matrix' => [
                            ['AT', 'BV', 'DP'],
                            ['V', 'AH', 'BD']
                        ]
                    ]
                ]
            );
    }
}
