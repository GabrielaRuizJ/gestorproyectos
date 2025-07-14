<?php
include("modelo/m_estado.php");
include("conexion.php");

function manejarOpcion($opcion){

    $ins = new m_estado();

    $source = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;

    $descripcion_estado = $_POST["descripcion_estado"] ?? null;
    

    switch($opcion) {
        case 'insertar':
            if ($descripcion_estado) {
                $ins->InsertarEstado($descripcion_estado);
            } else {
                echo json_encode(["success" => false, "message" => "Faltan datos para insertar estado"]);
            }
            break;

        case 'consulta_estados':
            $ins->ConsultaEstados();
            break;
        case 'modificar':
            // pendiente de implementar
            break;

        case 'eliminar':
            // pendiente de implementar
            break;
        default:
            echo json_encode(["success" => false, "message" => "Opción inválida"]);
        }

}

?>
