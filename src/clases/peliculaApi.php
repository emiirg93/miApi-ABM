<?php
include_once "pelicula.php";
include_once "IApiUsable.php";
class PeliculaApi extends Pelicula implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $ruta = './img/';

        $ArrayDeParametros = $request->getParsedBody();
        $idPelicula = PeliculaApi::CrearID();
        $nombre = $ArrayDeParametros['nombre'];
        $tipo = $ArrayDeParametros['tipo'];
        $fechaEstreno = $ArrayDeParametros['fechaEstreno'];
        $cantidadPublico = $ArrayDeParametros['cantidadPublico'];
        $nombreSinEspacios = PeliculaApi::QuitarEspaciosNombre($nombre);
        $rutaPelicula = PeliculaApi::TrabajarConFoto($ruta, $nombreSinEspacios, $idPelicula);

        $miPelicula = Pelicula::constructorFalso($idPelicula, $nombre, $tipo, $fechaEstreno, $cantidadPublico, $rutaPelicula);
        $miPelicula->InsertarPelicula();
        $response->getBody()->write("Pelicula Guardada");
        return $response;
    }
    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $elUsuario = Pelicula::TraerPelicula($id);
        $newResponse = $response->withJson($elUsuario, 200);
        return $newResponse;
    }
    public function TraerTodos($request, $response, $args)
    {
        $todosLosUsuarios = Pelicula::TraerPeliculas();
        $newResponse = $response->withJson($todosLosUsuarios, 200);
        return $newResponse;
    }

    public function BorrarUno($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
     	$id=$ArrayDeParametros['id'];
    
     	$cantidadDeBorrados=Pelicula::BorrarPelicula($id);

     	$objDelaRespuesta= new stdclass();
        $objDelaRespuesta->cantidad=$cantidadDeBorrados;
        
	    if($cantidadDeBorrados>0)
	    	{
	    		 $objDelaRespuesta->resultado="borrado con exito";
	    	}
	    	else
	    	{
	    		$objDelaRespuesta->resultado="se borro con exito";
            }
            
	    $newResponse = $response->withJson($objDelaRespuesta, 200);  
      	return $newResponse;
    }

    public static function TrabajarConFoto($ruta, $nombre, $idPelicula)
    {
        $nombreViejo = $_FILES['fotoPelicula']['tmp_name'];
        var_dump("ruta origen de la foto: " . $nombreViejo);

        $nombreNuevo = PeliculaApi::changeImgName($_FILES['fotoPelicula']['name'], $ruta, $nombre, $idPelicula);
        echo ("ruta actual: " . $nombreNuevo);
        if(move_uploaded_file($nombreViejo, $nombreNuevo))
        {
            echo "se movio genial";
        }
        else
        {
            echo "no se movio";
        }

        return $nombreNuevo;
    }

    public static function changeImgName($nameImg, $path, $nombreArticulo, $idCompra)
    {
        $arrayNameImg = explode('.', $nameImg);
        $arrayNameImg[0] = $path . $idCompra . "-" . $nombreArticulo;
        $nameImg = $arrayNameImg[0] . "." . $arrayNameImg[1];
        return $nameImg;
    }

    public static function CrearID()
    {
        $arrayPeliculas = Pelicula::TraerPeliculas();
        $max = 0;
        $id = 0;

        if (count($arrayPeliculas) != 0) {
            foreach ($arrayPeliculas as $pelicula) {
                if ($pelicula->id > $max) {
                    $max = $pelicula->id;
                    $id = $max;
                }
            }

            $id = $id + 1;
        } else {
            $id = 1;
        }

        return $id;
    }

    public static function QuitarEspaciosNombre($nombre)
    {
        $array = explode(" ", $nombre);
        $nombreSinEspacio = "";

        foreach ($array as $palabra) {
            $nombreSinEspacio .= $palabra;
        }

        var_dump($nombreSinEspacio);
        return $nombreSinEspacio;
    }

    public function ModificarUno($request, $response, $args) {
        //$response->getBody()->write("<h1>Modificar  uno</h1>");
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);    	
        $miPelicula = new Pelicula();
        $id=$ArrayDeParametros['id'];
        $nombre=$ArrayDeParametros['nombre'];
        $tipo=$ArrayDeParametros['tipo'];
        $fechaEstreno=$ArrayDeParametros['fechaEstreno'];
        $cantidadPublico=$ArrayDeParametros['cantidadPublico'];
        $fotoPelicula=$ArrayDeParametros['fotoPelicula'];

        $miPelicula = $miPelicula->constructorFalso($id, $nombre, $tipo, $fechaEstreno, $cantidadPublico, $fotoPelicula);

        $resultado =$miPelicula->ModificarPelicula();
        $objDelaRespuesta= new stdclass();
        //var_dump($resultado);
        $objDelaRespuesta->resultado=$resultado;
        $objDelaRespuesta->tarea="modificar";
        return $response->withJson($objDelaRespuesta, 200);		
   }
}
