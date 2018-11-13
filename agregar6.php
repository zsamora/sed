<?php
include_once("db_connect.php");
$nombre=$_POST["nombre"];
$finicio=$_POST["finicio"];
$ftermino=$_POST["ftermino"];
$pondmeta=$_POST["pondmeta"];
$pondcomp=$_POST["pondcomp"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO procesos (`nombre`,`establecimiento_id`,`finicio`,`ftermino`,`pondmeta`,`pondcomp`)
                        VALUES('$nombre',1,'$finicio','$ftermino', $pondmeta, $pondcomp)";
if ($conn->query($agregar) === TRUE) {
  header("Location: procesos.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
