<?php
include_once("db_connect.php");
$nombre=$_POST["nombre"];
$finicio=$_POST["finicio"];
$ftermino=$_POST["ftermino"];
$pondmeta=$_POST["pondmeta"];
$pondcomp=$_POST["pondcomp"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO procesos (`id`,`nombre`,`establecimiento_id`,`finicio`,`ftermino`,`pondmeta`,`pondcomp`)
                        SELECT COUNT(*) + 1,'$nombre',1,'$finicio','$ftermino', $pondmeta, $pondcomp
                          FROM procesos";
if ($conn->query($agregar) === TRUE) {
  header("Location: procesos.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
