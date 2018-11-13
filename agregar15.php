<?php
include_once("db_connect.php");
$perfil=$_POST["perfil"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO perfiles (`nombre`)
                          VALUES ('$perfil')";
if ($conn->query($agregar) === TRUE) {
  header("Location: perfiles.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
