<?php
include_once("db_connect.php");
$ciclo=$_POST["ciclo"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO ciclos (`id`,`nombre`)
                          VALUES ('$ciclo')";
if ($conn->query($agregar) === TRUE) {
  header("Location: ciclos.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
