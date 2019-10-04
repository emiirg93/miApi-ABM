<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

require __DIR__ . '/../vendor/autoload.php';
require '../src/clases/usuarioApi.php';

$app = new \Slim\App(["settings" => $config]);

//get

$app->group('/usuario', function () {
 
    $this->get('/', \usuarioApi::class . ':traerTodos');
   
    $this->get('/{id}', \usuarioApi::class . ':traerUno');
    $this->post('/', \usuarioApi::class . ':CargarUno');
    //$this->delete('/', \usuarioApi::class . ':BorrarUno');
    //$this->put('/', \usuarioApi::class . ':ModificarUno');
       
  });
