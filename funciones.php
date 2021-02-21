<?php
if($_REQUEST['action']){
    call_user_func($_REQUEST['action']);
}

function consultar(){
    include('conexion.php');
    $consulta = "SELECT * FROM alumnos";
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows > 0) {

        $arrayDatos = array();
        while($fila = $resultado->fetch_assoc()) {
            array_push($arrayDatos, $fila);    
        }
        echo json_encode($arrayDatos);
    
    } else {
        echo "0 results";
    }
    $conexion->close();
}

function guardar(){
    include('conexion.php');

    $editar = $_POST['datos']['editar'];
    echo $editar;
    if($_POST['datos']['editar'] == 0){
        echo $_POST['datos']['editar'];
        $consulta = 'INSERT INTO alumnos (nombre, paterno, materno)
        VALUES("'.$_POST['datos']['nombre'].'", "'.$_POST['datos']['paterno'].'", "'.$_POST['datos']['materno'].'")';    
    
    }else{
        $consulta = 'UPDATE alumnos SET nombre = "'.$_POST['datos']['nombre'].'", paterno = "'.$_POST['datos']['paterno'].'",  materno = "'.$_POST['datos']['materno'].'" WHERE idalumno = "'.$_POST['datos']['idAlumno'].'" ';
    }
    
    if ($conexion->query($consulta) === TRUE) {
        echo "Registro guardado con éxito";
    } else {
        echo "Error: " . $consulta . "<br>" . $conexion->error;
    }

    $conexion->close();
}

function eliminar(){
    include('conexion.php');
    $consulta = 'DELETE FROM Alumnos WHERE idalumno = "'.$_POST['idAlumno'].'"';

    if ($conexion->query($consulta) === TRUE) {
        echo "Registro eliminado con éxito";
    } else {
        echo "Error: " . $consulta . "<br>" . $conexion->error;
    }

    $conexion->close();
}

function obtenerAlumno(){
    include('conexion.php');
    $consulta = 'SELECT * FROM alumnos WHERE idalumno = "'.$_POST['idAlumno'].'"';
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows > 0) {

        $arrayDatos = array();
        while($fila = $resultado->fetch_assoc()) {
            array_push($arrayDatos, $fila);    
        }
        echo json_encode($arrayDatos);
    
    } else {
        echo "0 results";
    }
    $conexion->close();
}

?>