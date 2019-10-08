<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
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
    //$this->delete('/', \usuarioApi::class . ':BorrarUno');
    //$this->put('/', \usuarioApi::class . ':ModificarUno');
       
  });
