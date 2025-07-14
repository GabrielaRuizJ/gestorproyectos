<?php

class m_tarea{
	function m_tarea(){}

	function InsertarTarea($proyecto_id,$usuario_id,$nombre_tarea,$descripcion,$fecha_vencimiento,$estado){		
		$sql = "INSERT INTO tareas (proyecto_id,usuario_id,nombre_tarea,descripcion,fecha_vencimiento,estado_id) VALUES ($proyecto_id,$usuario_id,'$nombre_tarea','$descripcion','$fecha_vencimiento',$estado)";
		$conexion= new conexion();
        $conexion->conectarBD();
		$data = $conexion->ejeCon($sql,0);
		if ($data === NULL) {
			echo json_encode (["success" => false, "error" => "Error al insertar el proyecto "]);
		} else {
			echo json_encode (["success" => true, "message" => "Tarea registrada correctamente "]);
		}
		
	}

	function ConsultaTareas($proyecto_id){
		$sql = "SELECT tareas.*,estados.estado FROM tareas INNER JOIN estados ON estados.id_estado = tareas.estado_id WHERE proyecto_id=$proyecto_id";
		$conexion= new conexion();
        $conexion->conectarBD();
		$data = $conexion->ejeCon($sql,0);
		if ($data === NULL) {
			echo json_encode (["success" => true, "message" => "No hay tareas en el proyecto "]);
		} else {
			$tareas = [];
			foreach ($data as $row) {
				$limpio = [];
				foreach ($row as $key => $value) {
					if (!is_numeric($key)) {
						$limpio[$key] = $value;
					}
				}
				$tareas[] = $limpio;
			}
			echo json_encode (["success" => true, "message" => $tareas]);
		}
	}

    function ModificarTarea($nombre_tarea,$descripcion,$fecha_vencimiento,$estado,$tarea_id){        
		$sql = "UPDATE tareas SET nombre_tarea='$nombre_tarea',descripcion='$descripcion',fecha_vencimiento='$fecha_vencimiento',estado_id= $estado WHERE tarea_id=$tarea_id";
		$conexion= new conexion();
        $conexion->conectarBD();
		$data = $conexion->ejeCon($sql,0);
		if ($data === NULL) {
			echo json_encode (["success" => false, "error" => "Error al modificar tarea "]);
		} else {
			echo json_encode (["success" => true, "message" => "Tarea modificada correctamente "]);
		}
	}

    function EliminarTarea($tarea_id){        
		$sql = "DELETE FROM tareas WHERE tarea_id=$tarea_id";
		$conexion= new conexion();
        $conexion->conectarBD();
		$data = $conexion->ejeCon($sql,0);
		if ($data === NULL) {
			echo json_encode (["success" => false, "error" => "Error al eliminar tarea "]);
		} else {
			echo json_encode (["success" => true, "message" => "Tarea eliminada correctamente "]);
		}
	}

}
?>
