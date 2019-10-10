<?php

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

require __DIR__ . '/../vendor/autoload.php';
require '../src/clases/peliculaApi.php';

$app = new \Slim\App(["settings" => $config]);

//get

$app->group('/pelicula', function () {

    $this->get('/', \PeliculaApi::class . ':traerTodos');

    $this->get('/{id}', \PeliculaApi::class . ':traerUno');
    $this->post('/', \PeliculaApi::class . ':CargarUno');
    $this->delete('/', \PeliculaApi::class . ':BorrarUno');
    $this->put('/', \PeliculaApi::class . ':ModificarUno');

});
