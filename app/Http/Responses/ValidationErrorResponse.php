<?php


namespace App\Http\Responses;


class ValidationErrorResponse extends ErrorResponse
{
    public function __construct(string|array $errors)
    {
        parent::__construct($errors, 'validation-error');

        $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
