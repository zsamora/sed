<?php
session_start();
if($_SESSION['id']!=1 && $_SESSION['id']!=0){ // Poner aquí las id de quien puede tener acceso
	header("Location: index.php");
}
include_once("db_connect.php");
$id_eliminar = $_GET['id_el'];
$evalcomp = "SELECT id FROM evaluaciones_comp
										WHERE proceso_id = $id_eliminar";
$evalcomp_result = $conn->query($evalcomp) or die ("database error:".$conn->error);
$evalind = "SELECT id FROM evaluaciones_ind
											WHERE proceso_id = $id_eliminar";
$evalind_result = $conn->query($evalind) or die ("database error:".$conn->error);
while ($fila = $evalcomp_result->fetch_assoc()){
	$id = $fila['id'];
  $eliminar_rescomp = "DELETE FROM resultados_comp WHERE evaluacion_id = $id";
	$eliminar_rescomp_result = $conn->query($eliminar_rescomp) or die ("database error:".$conn->error);
}
while ($fila = $evalind_result->fetch_assoc()){
	$id = $fila['id'];
  $eliminar_resind = "DELETE FROM resultados_ind WHERE evaluacion_id = $id";
	$eliminar_resind_result = $conn->query($eliminar_resind) or die ("database error:".$conn->error);
}
header("Location: procesos.php");
die();
?>
