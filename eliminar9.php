<?php
session_start();
if($_SESSION['id']!=1 && $_SESSION['id']!=0){ // Poner aquí las id de quien puede tener acceso
	header("Location: index.php");
}
include_once("db_connect.php");
$id_eliminar = $_GET['id_el'];
$eliminar = "DELETE FROM criterios WHERE id = $id_eliminar";
$eliminar_result = $conn->query($eliminar) or die ("database error:".$conn->error);
$eliminar2 = "DELETE FROM comp_crit WHERE criterio_id = $id_eliminar";
$eliminar2_result = $conn->query($eliminar2) or die ("database error:".$conn->error);
$evalcomp = "SELECT id FROM evaluaciones_comp WHERE criterio_id = $id_eliminar";
$evalcomp_result = $conn->query($evalcomp) or die ("database error:".$conn->error);
while ($fila = $evalcomp_result->fetch_assoc()){
	$id = $fila['id'];
	$eliminar_evalcomp = "DELETE FROM evaluaciones_comp WHERE id = $id";
	$eliminar_evalcomp_result = $conn->query($eliminar_evalcomp) or die ("database error:".$conn->error);
	$eliminar_rescomp = "DELETE FROM resultados_comp WHERE evaluacion_id = $id";
	$eliminar_rescomp_result = $conn->query($eliminar_rescomp) or die ("database error:".$conn->error);
}
header("Location: criterios.php");
die();
?>
