<?php
include_once("db_connect.php");
$cargo=$_POST["cargo"];
$indicador=$_POST["ind"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO indicador_cargos (`cargo_id`,`indicador_id`)
                          VALUES ($cargo,$indicador)";
if ($conn->query($agregar) === TRUE) {
  header("Location: cargos.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
