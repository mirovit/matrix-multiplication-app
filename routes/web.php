<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->post('/multiply', [
    'uses' => 'MultiplicationController',
    'as'   => 'multiplication.calculate',
]);

$router->get('/test', function (\Illuminate\Http\Request $request) {
    return ['value' => (new \App\Services\Formatters\NumberToLetter())->format((int)$request->get('number'))];
});
