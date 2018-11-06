<?php
include_once("db_connect.php");
$proceso=$_POST["proc"];
$competencia=$_POST["comp"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO proc_comp (`proceso_id`,`competencia_id`)
                          VALUES ($proceso,$competencia)";
if ($conn->query($agregar) === TRUE) {
  header("Location: procesos.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
