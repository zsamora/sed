<?php
include_once("db_connect.php");
$meta=$_POST["meta"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO metas (`descripcion`)
                          VALUES('$meta')";
if ($conn->query($agregar) === TRUE) {
  header("Location: metas.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
