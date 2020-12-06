<?php


namespace App\Http\Responses;


class ErrorResponse extends Response
{
    public function __construct(string|array $errors, string $errorCode)
    {
        parent::__construct($this->getErrorBody($errors, $errorCode), Response::HTTP_BAD_REQUEST);
    }
}
