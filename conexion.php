<?php
$conexion = new mysqli('localhost', 'root', 'San_Francisco', 'escuela');

if ($conexion->connect_error) {
  die("Error en la conexion: " . $conexion->connect_error);
}
//echo "Conexion éxitosa";
?>