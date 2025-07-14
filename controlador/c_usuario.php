<?php
include("modelo/m_usuario.php");
include("conexion.php");

function manejarOpcion($opcion){

    $ins = new m_usuario();

    $source = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;

    $id_usuario = $_POST["id_usuario"] ?? null;
    $usuario    = $_POST["usuario"] ?? null;
    $clave      = $_POST["clave"] ?? null;
    $nombre     = $_POST["nombre"] ?? null;
    $apellido   = $_POST["apellido"] ?? null;
    $email      = $_POST["email"] ?? null;
    $estado     = $_POST["estado"] ?? true;
    $idperfil   = $_POST["idperfil"] ?? 2;

    switch($opcion) {
        case 'insertar':
            if ($usuario && $clave && $nombre && $apellido && $email) {
                $ins->InsertarUsuario($usuario, $clave, $nombre, $apellido, $email, $idperfil);
            } else {
                echo json_encode(["success" => false, "message" => "Faltan datos para insertar usuario"]);
            }
            break;

        case 'consulta_usuario':
            if ($id_usuario) {
                $ins->SeleccionarUsuario($id_usuario);
            } else {
                echo json_encode(["success" => false, "message" => "Falta ID para consultar usuario"]);
            }
            break;
        case 'consulta_usuarios':
            $res = $ins->SeleccionarUsuarios();
            echo json_encode($res);
            break;

        case 'modificar':
            if ($usuario && $nombre && $apellido && $email && $id_usuario) {
                $ins->ModificarUsuario($usuario,$nombre,$apellido,$email,$id_usuario);
            } else {
                echo json_encode(["success" => false, "message" => "Falta datos para modificar el usuario"]);
            }            
            break;
        case 'login':
            if ($usuario && $clave) {
                $ins->IniciarSesion($usuario, $clave);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Faltan datos para iniciar sesión"
                ]);
            }
            break;
        case 'logout':
            session_start();
            session_unset();
            session_destroy();
            echo json_encode(["success" => true, "message" => "Sesión cerrada"]);
            break;
        
        default:
            echo json_encode(["success" => false, "message" => "Opción inválida"]);
        }

}

?>
