<?php
session_start();
if($_SESSION['id']!=1 && $_SESSION['id']!=0){ // Poner aquí las id de quien puede tener acceso
	header("Location: index.php");
}
include_once("db_connect.php");
$id_eliminar = $_GET['id_el'];
$eliminar = "DELETE FROM metas WHERE id = $id_eliminar";
$eliminar_result = $conn->query($eliminar) or die ("database error:".$conn->error);
$indicadores = "SELECT id FROM indicadores WHERE meta_id = $id_eliminar";
$indicadores_result = $conn->query($indicadores) or die ("database error:".$conn->error);
while ($fila = $indicadores_result->fetch_assoc()) {
	$id = $fila['id'];
	$eliminar2 = "DELETE FROM proc_ind WHERE indicador_id = $id";
	$eliminar2_result = $conn->query($eliminar2) or die ("database error:".$conn->error);
	$eliminar3 = "DELETE FROM indicadores WHERE id = $id";
	$eliminar3_result = $conn->query($eliminar3) or die ("database error:".$conn->error);
	$eliminar4 = "DELETE FROM indicador_cargos WHERE indicador_id = $id";
	$eliminar4_result = $conn->query($eliminar4) or die ("database error:".$conn->error);
}
$evalind = "SELECT id FROM evaluaciones_ind WHERE meta_id = $id_eliminar";
$evalind_result = $conn->query($evalind) or die ("database error:".$conn->error);
while ($fila2 = $evalind_result->fetch_assoc()){
	$id2 = $fila2['id'];
	$eliminar_evalind = "DELETE FROM evaluaciones_ind WHERE id = $id2";
	$eliminar_evalind_result = $conn->query($eliminar_evalind) or die ("database error:".$conn->error);
	$eliminar_resind = "DELETE FROM resultados_ind WHERE evaluacion_id = $id2";
	$eliminar_resind_result = $conn->query($eliminar_resind) or die ("database error:".$conn->error);
}
header("Location: metas.php");
die();
?>
