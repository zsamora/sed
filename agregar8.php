<?php
include_once("db_connect.php");
$proceso=$_POST["proc"];
$indicador=$_POST["ind"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO proc_ind (`proceso_id`,`indicador_id`)
                          VALUES ($proceso,$indicador)";
if ($conn->query($agregar) === TRUE) {
  header("Location: procesos.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
