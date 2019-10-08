<?php
include_once "AccesoDatos.php";
class Pelicula
{
    public $id;
    public $nombre;
    public $tipo;
    public $fechaEstreno;
    public $cantidadPublico;
    public $fotoPelicula;

    public static function constructorFalso($id, $nombre, $tipo, $fechaEstreno, $cantidadPublico, $fotoPelicula)
    {
        $pelicula = new Pelicula();

        $pelicula->id = $id;
        $pelicula->nombre = $nombre;
        $pelicula->tipo = $tipo;
        $pelicula->fechaEstreno = $fechaEstreno;
        $pelicula->cantidadPublico = $cantidadPublico;
        $pelicula->fotoPelicula = $fotoPelicula;

        return $pelicula;
    }


    public function InsertarPelicula()
    {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into peliculas (id,nombre,tipo,fechaEstreno,cantidadPublico,fotoPelicula)values(:id,:nombre,:tipo,:fechaEstreno,:cantidadPublico,:fotoPelicula)");
            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':fechaEstreno', $this->fechaEstreno, PDO::PARAM_STR);
            $consulta->bindValue(':cantidadPublico', $this->cantidadPublico, PDO::PARAM_INT);
            $consulta->bindValue(':fotoPelicula', $this->fotoPelicula, PDO::PARAM_STR);
            		
            return $consulta->execute();
    }
    public static function TraerPelicula($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from peliculas where id = $id");
			$consulta->execute();
			$cdBuscado= $consulta->fetchObject('Pelicula');
			return $cdBuscado;					
    }
    
    public static function TraerPeliculas()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from peliculas WHERE 1=1");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pelicula");		
	}
}