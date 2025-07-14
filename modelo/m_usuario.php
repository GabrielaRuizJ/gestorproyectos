<?php

class m_usuario{
	function m_usuario(){}

	function InsertarUsuario($usuario,$clave,$nombre,$apellido,$email,$idperfil){
		$clave_hashed = password_hash($clave, PASSWORD_DEFAULT);
		$sql = "INSERT INTO usuarios (usuario,clave,nombre,apellido,email,id_perfil) VALUES ('$usuario','$clave_hashed','$nombre','$apellido','$email',$idperfil)";
		$conexion= new conexion();
        $conexion->conectarBD();
		$data = $conexion->ejeCon($sql,0);
		if ($data === 1062) {
			echo json_encode (["success" => false, "error" => "El usuario ya existe en el sistema"]);
		} else if ($data === NULL) {
			echo json_encode (["success" => false, "error" => "Error al insertar el usuario ".$data]);
		} else {
			echo json_encode (["success" => true, "message" => "Usuario insertado"]);
		}
		
	}

	function IniciarSesion($usuario,$clave){
		$sql = "SELECT * FROM usuarios  WHERE usuario = '$usuario' AND estado = true";
		$conexionBD = new conexion();
		$conexionBD->conectarBD();
		$data = $conexionBD->ejeCon($sql, 0);

		if ($data && count($data) > 0) {
			$user = $data[0];
			if (password_verify($clave, $user['clave'])) {
				unset($user['clave']); 
				session_start();
				$_SESSION['usuario'] = $user;

				echo json_encode(["success" => true, "usuario" => $user]);
			} else {
				echo json_encode(["success" => false, "message" => "Contraseña incorrecta"]);
			}
		} else {
			echo json_encode(["success" => false, "message" => "Usuario no encontrado o inactivo"]);
		}
	}

	function ModificarUsuario($usuario,$nombre,$apellido,$email,$id_usuario){
		$sql = "UPDATE usuarios SET usuario='$usuario',nombre='$nombre', apellido='$apellido',email='$email' WHERE id_usuario ='$id_usuario' ";
		$conexionBD = new conexion();
		$conexionBD->conectarBD();
		$data = $conexionBD->ejeCon($sql, 0);
		if ($data === 1062) {
			echo json_encode (["success" => false, "error" => "El usuario ya existe en el sistema"]);
		} else if ($data === NULL) {
			echo json_encode (["success" => false, "error" => "Error al modificar el usuario "]);
		} else {
			echo json_encode (["success" => true, "message" => "Usuario modificado"]);
		}
	}

	function SeleccionarUsuario($id_usuario){
		$sql = "SELECT * FROM usuarios WHERE id_usuario=$id_usuario";
		$conexion = new conexion();
		$conexion->conectarBD();
		$data = $conexion->ejeCon($sql, 0);

		if ($data === NULL) {
			echo json_encode(["success" => false, "error" => "Error al consultar el usuario"]);
		} else {
			$usuario = [];
			foreach ($data[0] as $key => $value) {
				if (!is_numeric($key) && $key !== 'clave') {
					$usuario[$key] = $value;
				}
			}
			echo json_encode(["success" => true, "usuario" => $usuario]);
		}
	}

	function SeleccionarUsuarios(){
		$sql = "SELECT * FROM usuarios ORDER BY nombre";
		$data = $this->select($sql);
		return $data;
	}

}
?>
