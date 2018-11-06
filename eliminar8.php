<?php
session_start();
if($_SESSION['id']!=1 && $_SESSION['id']!=0){ // Poner aquí las id de quien puede tener acceso
	header("Location: index.php");
}
include_once("db_connect.php");
$proceso = $_GET['proc_id'];
$indicador = $_GET['ind_id'];
$eliminar = "DELETE FROM proc_ind WHERE proceso_id = $proceso AND indicador_id = $indicador";
$eliminar_result = $conn->query($eliminar) or die ("database error:".$conn->error);
$evalind = "SELECT id FROM evaluaciones_ind WHERE indicador_id = $indicador";
$evalind_result = $conn->query($evalind) or die ("database error:".$conn->error);
while ($fila = $evalind_result->fetch_assoc()){
	$id = $fila['id'];
	$eliminar_evalind = "DELETE FROM evaluaciones_ind WHERE id = $id";
	$eliminar_evalind_result = $conn->query($eliminar_evalind) or die ("database error:".$conn->error);
	$eliminar_resind = "DELETE FROM resultados_ind WHERE evaluacion_id = $id";
	$eliminar_resind_result = $conn->query($eliminar_resind) or die ("database error:".$conn->error);
}
header("Location: procesos.php");
die();
?>
