<?php
include_once("db_connect.php");
$cargo=$_POST["cargo"];
$perfil=$_POST["perf"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO cargos (`nombre`,`perfil_id`)
                          VALUES('$cargo', $perfil)";
if ($conn->query($agregar) === TRUE) {
  header("Location: cargos.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
