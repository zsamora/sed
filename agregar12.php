<?php
include_once("db_connect.php");
$meta=$_POST["meta"];
$descripcion=$_POST["descripcion"];
$no_cumplido=$_POST["no_cumplido"];
$minimo=$_POST["minimo"];
$esperado=$_POST["esperado"];
$sobre_esperado=$_POST["sobre_esperado"];
$ponderacion=$_POST["ponderacion"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO indicadores (`meta_id`,`descripcion`,`minimo`,`no_cumplido`,`esperado`,`sobre_esperado`,`ponderacion`)
                 VALUES ($meta,'$descripcion','$minimo','$no_cumplido','$esperado','$sobre_esperado',$ponderacion)";
if ($conn->query($agregar) === TRUE) {
  header("Location: indicadores.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
