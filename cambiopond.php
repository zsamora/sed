<?php
session_start();
include_once("db_connect.php");
$proc=$_POST["proc"];
$pondmeta=$_POST["pondmeta"];
$pondcomp=$_POST["pondcomp"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$cambiar = "UPDATE procesos
               SET pondmeta = $pondmeta, pondcomp = $pondcomp
             WHERE id = $proc";
if ($conn->query($cambiar) === TRUE) {
  header("Location: procesos.php");
} else {
    echo "Error: " . $cambiar . "<br>" . $conn->error;
}
die();
?>
