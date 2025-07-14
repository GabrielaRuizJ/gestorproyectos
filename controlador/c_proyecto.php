<?php
include("modelo/m_proyecto.php");
include("conexion.php");

function manejarOpcion($opcion){

    $ins = new m_proyecto();

    $source = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;

    $nombre_proyecto       = $_POST["nombre_proyecto"] ?? null;
    $descripcion_proyecto  = $_POST["descripcion_proyecto"] ?? null;
    $fechalimite_proyecto  = $_POST["fechalimite_proyecto"] ?? null;
    $tarifa_proyecto       = $_POST["tarifa_proyecto"] ?? null;
    $usuario               = $_POST["usuario_proyecto"] ?? null;
    $id_proyecto           = $_POST["id_proyecto"] ?? null;
    $id_estado           = $_POST["id_estado"] ?? null;


    switch($opcion) {
        case 'insertar':
            if ($nombre_proyecto && $descripcion_proyecto && $fechalimite_proyecto && $tarifa_proyecto && $usuario) {
                $ins->InsertarProyectos($nombre_proyecto, $descripcion_proyecto, $fechalimite_proyecto, $tarifa_proyecto, $usuario);
            } else {
                echo json_encode(["success" => false, "message" => "Faltan datos para insertar proyecto "]);
            }
            break;

        case 'consulta_proyectos':
            if ($usuario) {
                $ins->ConsultaProyectos($usuario);
            } else {
                echo json_encode(["success" => false, "message" => "Falta ID de usuario para consultar proyectos "]);
            }
            break;
        case 'modificar':
            if ($nombre_proyecto && $descripcion_proyecto && $fechalimite_proyecto && $id_estado && $tarifa_proyecto && $usuario && $id_proyecto) {
                $ins->ModificaProyecto($nombre_proyecto,$descripcion_proyecto,$fechalimite_proyecto,$id_estado,$tarifa_proyecto,$usuario,$id_proyecto);
            } else {
                echo json_encode(["success" => false, "message" => "Falta datos para modificar el proyecto "]);
            }            
            break;
        default:
            echo json_encode(["success" => false, "message" => "Opción inválida"]);
        }

}

?>
