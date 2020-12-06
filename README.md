# Matrix Multiplication App

[![Build Status](https://travis-ci.org/mirovit/matrix-multiplication-app.svg?branch=master)](https://travis-ci.org/mirovit/matrix-multiplication-app)
[![Maintainability](https://api.codeclimate.com/v1/badges/03b388c5ded9568a4797/maintainability)](https://codeclimate.com/github/mirovit/matrix-multiplication-app/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/03b388c5ded9568a4797/test_coverage)](https://codeclimate.com/github/mirovit/matrix-multiplication-app/test_coverage)

## Requirements

The only requirement is PHP 8.

## Installation

Get the project by downloading or cloning the repo.

Then, enter the project folder and execute `composer install`.  Add value for APP_KEY in the .env file that was created.

## Running Tests

Execute `php ./vendor/bin/phpunit` from the project root.

## Postman Example Usage

Postman collection and environment files are located in the project root folder. You can use those to test your API.

- Matrix App API.postman_collection.json
- Matrix App API ENV.postman_environment.json

## Available API methods

- POST /multiply
  - matrixA - required, string
  - matrixB - required, string
  - rowDelimiter - optional, string, default is ;
  - columnDelimiter - optional, string default is ,
    
## Response Structure
- Success Response - HTTP 200
```json
{
    "status": "success",
    "data": {
        "matrix": [
            [
                "AT",
                "BV",
                "DP"
            ],
            [
                "V",
                "AH",
                "BD"
            ]
        ]
    }
}
```

- Validation Error Response - HTTP 422
```json
{
    "status": "error",
    "error_code": "validation-error",
    "errors": [
        "Matrix B should have 3 rows to match the Matrix A columns. Matrix B contains 2 rows."
    ]
}
```
