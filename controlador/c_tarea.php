<?php
include("modelo/m_tarea.php");
include("conexion.php");

function manejarOpcion($opcion){

    $ins = new m_tarea();

    $source = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;

    $tarea_id            = $_POST["tarea_id"] ?? null;
    $proyecto_id         = $_POST["proyecto_id"] ?? null;
    $usuario_id          = $_POST["usuario_id"] ?? null;
    $nombre_tarea        = $_POST["nombre_tarea"] ?? null;
    $descripcion         = $_POST["descripcion"] ?? null;
    $fecha_vencimiento   = $_POST["fecha_vencimiento"] ?? null;
    $estado              = $_POST["estado"] ?? null;
    $tiempo_dedicado     = $_POST["tiempo_dedicado"] ?? null;
    

    switch($opcion) {
        case 'insertar':
            if ( $proyecto_id && $usuario_id && $nombre_tarea && $descripcion && $fecha_vencimiento && $estado) {
                $ins->InsertarTarea($proyecto_id,$usuario_id,$nombre_tarea,$descripcion,$fecha_vencimiento,$estado);
            } else {
                echo json_encode(["success" => false, "message" => "Faltan datos para insertar la tarea del proyecto"]);
            }
            break;
        case 'consulta_tareas':
            if ($proyecto_id) {
                $ins->ConsultaTareas($proyecto_id);
            } else {
                echo json_encode(["success" => false, "message" => "Falta ID de proyecto para consultar las tareas "]);
            }
            break;
        case 'modificar':
            if ( $nombre_tarea && $descripcion && $fecha_vencimiento && $estado && $tarea_id) {
                $ins->ModificarTarea($nombre_tarea,$descripcion,$fecha_vencimiento,$estado,$tarea_id);
            } else {
                echo json_encode(["success" => false, "message" => "Faltan datos para modificar la tarea del proyecto"]);
            }
            break;

        case 'eliminar':
             if ($tarea_id) {
                $ins->EliminarTarea($tarea_id);
            } else {
                echo json_encode(["success" => false, "message" => "Faltan datos para eliminar la tarea del proyecto"]);
            }
            break;
        default:
            echo json_encode(["success" => false, "message" => "Opción inválida"]);
        }

}

?>
