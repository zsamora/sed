<?php
include_once("db_connect.php");
$asignatura=$_POST["asig"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO asignaturas (`id`,`nombre`)
                          SELECT COUNT(*), '$asignatura'
                            FROM asignaturas";
if ($conn->query($agregar) === TRUE) {
  header("Location: asignaturas.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
