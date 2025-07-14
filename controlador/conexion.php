<?php

class conexion{
	var $link;
	var $resultado;

	function conectarBD(){
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
		include("configuracion.php");
		$this->link = mysqli_connect($serv_db,$usu_db,$pass_db);
		if (!$this->link){
			die("<h5>No se logro realizar la conexion</h5>");
		}
		$db2= mysqli_select_db($this->link,$db);
		if (!$db2){
			echo "no se puede conectar db";
		}
		mysqli_query($this->link,"SET NAMES 'utf8'");
	}

	function desconectarBD(){
		mysqli_close($this->link);
	}

	function ejeCon($con, $op){
	    try {
			$this->resultado = mysqli_query($this->link,$con) ;
			if($this->resultado){

				if ($op==0){
					while ($linea = mysqli_fetch_array($this->resultado)){
						$arrayResultado[] = $linea;
					}
				}else if($op==3){
					$arrayResultado = $this->link->insert_id;
				}else{
					$arrayResultado[] =0;
				}
				$resarr = isset($arrayResultado) ? $arrayResultado:NULL;
				if($resarr){
					return $arrayResultado;
				}

			}else{
				$error = $this->link->errno;
				return $error;

			}
		} catch (\Throwable $th) {
			return $th->getCode();
		}
		
		
	}
}
?>