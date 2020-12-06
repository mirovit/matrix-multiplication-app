<?php


namespace App\Http\Responses;


class SuccessResponse extends Response
{
    public function __construct(string|array $data)
    {
        parent::__construct($this->getSuccessBody($data));
    }
}
