<?php

class m_estado{
	function m_estado(){}

	function InsertarEstado($nombre,$descripcion,$fecha_fin,$tarifa,$usuario){		
		$sql = "INSERT INTO proyectos (nombre_proyecto,descripcion,fecha_fin,estado_id,tarifa,usuario_id) VALUES ('$nombre','$descripcion','$fecha_fin',1,$tarifa,$usuario)";
		$conexion= new conexion();
        $conexion->conectarBD();
		$data = $conexion->ejeCon($sql,0);
		if ($data === NULL) {
			echo json_encode (["success" => false, "error" => "Error al insertar el proyecto ".$data]);
		} else {
			echo json_encode (["success" => true, "message" => "Proyecto registrado correctamente".$sql.' ']);
		}
		
	}

	function ConsultaEstados(){
		$sql = "SELECT * FROM estados";
		$conexion= new conexion();
        $conexion->conectarBD();
		$data = $conexion->ejeCon($sql,0);
		if ($data === NULL) {
			echo json_encode (["success" => false, "error" => "Error al consultar los estados "]);
		} else {
			$estados = [];
			foreach ($data as $row) {
				$limpio = [];
				foreach ($row as $key => $value) {
					if (!is_numeric($key)) {
						$limpio[$key] = $value;
					}
				}
				$estados[] = $limpio;
			}
			echo json_encode (["success" => true, "message" => $estados]);
		}
	}

}
?>
