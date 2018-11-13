<?php
include_once("db_connect.php");
$nombre=$_POST["nombre"];
$descripcion=$_POST["descripcion"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO competencias (`nombre`, `descripcion`)
                          VALUES ('$nombre', '$descripcion')";
if ($conn->query($agregar) === TRUE) {
  header("Location: competencias.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
