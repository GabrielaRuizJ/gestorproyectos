<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$modulo = isset($_REQUEST["modulo"]) ? $_REQUEST["modulo"]:NULL; 
$opcion = isset($_REQUEST["opcion"]) ? $_REQUEST["opcion"]:NULL;

if (!$modulo || !$opcion) {
    echo json_encode(["success" => false, "message" => "Parámetros 'modulo' y 'opcion' requeridos"]);
    exit;
}

$archivo_controlador = "controlador/c_{$modulo}.php";

if (file_exists($archivo_controlador)) {
    include($archivo_controlador);
    manejarOpcion($opcion); 
} else {
    echo json_encode(["success" => false, "message" => "modulo '$modulo' no encontrada"]);
}
