<?php
include_once("db_connect.php");
$competencia=$_POST["comp"];
$criterio=$_POST["crit"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO comp_crit (`competencia_id`,`criterio_id`)
                          VALUES ($competencia,$criterio)";
if ($conn->query($agregar) === TRUE) {
  header("Location: criterios.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
