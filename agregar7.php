<?php
include_once("db_connect.php");
$perfil=$_POST["perf"];
$competencia=$_POST["comp"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO comp_perfiles (`perfil_id`,`competencia_id`)
                          VALUES ($perfil,$competencia)";
if ($conn->query($agregar) === TRUE) {
    header("Location: competencias.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
