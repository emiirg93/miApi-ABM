<?php
include_once "usuario.php";
include_once "IApiUsable.php";
class usuarioApi extends usuario implements IApiUsable
{
    public function CargarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        $usuario= $ArrayDeParametros['usuario'];
        $password= $ArrayDeParametros['password'];
        
        $miUsuario = new usuario();
        $miUsuario->usuario=$usuario;
        $miUsuario->password=$password;
        $miUsuario->InsertarElCdParametros();
        $response->getBody()->write("Usuario Guardado");
        return $response;
    }
    public function TraerUno($request, $response, $args) {
        $id=$args['id'];
        $elUsuario=usuario::TraerUnUsuario($id);
        $newResponse = $response->withJson($elUsuario, 200);  
        return $newResponse;
    }
    public function TraerTodos($request, $response, $args) {
        $todosLosUsuarios=usuario::TraerTodoLosUsuarios();
        $newResponse = $response->withJson($todosLosUsuarios, 200);  
        return $newResponse;
    }
}