# Matrix Multiplication App

## Requirements

The only requirement is PHP 8.

## Installation

Get the project by downloading or cloning the repo.

Then, enter the project folder and execute `composer install`.  Add value for APP_KEY in the .env file that was created.

## Running Tests

Execute `php ./vendor/bin/phpunit` from the project root.

## Postman Example Usage

Postman collection and environment files are located in the project root folder. You can use those to test your API.

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
