<?php

class m_proyecto{
	function m_proyecto(){}

	function InsertarProyectos($nombre,$descripcion,$fecha_fin,$tarifa,$usuario){		
		$sql = "INSERT INTO proyectos (nombre_proyecto,descripcion,fecha_fin,estado_id,tarifa,usuario_id) VALUES ('$nombre','$descripcion','$fecha_fin',1,$tarifa,$usuario)";
		$conexion= new conexion();
        $conexion->conectarBD();
		$data = $conexion->ejeCon($sql,0);
		if ($data === NULL) {
			echo json_encode (["success" => false, "error" => "Error al insertar el proyecto "]);
		} else {
			echo json_encode (["success" => true, "message" => "Proyecto registrado correctamente"]);
		}
		
	}

	function ConsultaProyectos($id_usuario){
		$sql = "SELECT proyectos.*,estados.estado,estados.id_estado FROM proyectos INNER JOIN estados ON estados.id_estado = proyectos.estado_id WHERE usuario_id=$id_usuario";
		$conexion= new conexion();
        $conexion->conectarBD();
		$data = $conexion->ejeCon($sql,0);
		if ($data === NULL) {
			echo json_encode (["success" => false, "error" => "Error al consultar los proyectos "]);
		} else {
			$proyectos = [];
			foreach ($data as $row) {
				$limpio = [];
				foreach ($row as $key => $value) {
					if (!is_numeric($key)) {
						$limpio[$key] = $value;
					}
				}
				$proyectos[] = $limpio;
			}
			echo json_encode (["success" => true, "message" => $proyectos]);
		}
	}

	function ModificaProyecto($nombre,$descripcion,$fecha_fin,$estado,$tarifa,$usuario,$id_proyecto){		
		$sql = "UPDATE proyectos SET nombre_proyecto='$nombre',descripcion='$descripcion',fecha_fin='$fecha_fin',estado_id=$estado,tarifa=$tarifa,usuario_id=$usuario WHERE proyecto_id =$id_proyecto ";
		$conexion= new conexion();
        $conexion->conectarBD();
		$data = $conexion->ejeCon($sql,0);
		if ($data === NULL) {
			echo json_encode (["success" => false, "error" => "Error al modificar el proyecto ".$data]);
		} else {
			echo json_encode (["success" => true, "message" => "Proyecto modificado correctamente"]);
		}
		
	}

}
?>
