<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);


$app->withEloquent();
$app->withFacades();


$app->group(['namespace' => 'App\Controllers'], function ($app) {
    require __DIR__.'/routes.php';
});

return $app;
