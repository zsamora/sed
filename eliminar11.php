<?php
session_start();
if($_SESSION['id']!=1 && $_SESSION['id']!=0){ // Poner aquí las id de quien puede tener acceso
	header("Location: index.php");
}
include_once("db_connect.php");
$proceso = $_GET['proc_id'];
$competencia = $_GET['comp_id'];
$eliminar = "DELETE FROM proc_comp WHERE proceso_id = $proceso AND competencia_id = $competencia";
$eliminar_result = $conn->query($eliminar) or die ("database error:".$conn->error);
$evalcomp = "SELECT id FROM evaluaciones_comp WHERE competencia_id = $competencia";
$evalcomp_result = $conn->query($evalcomp) or die ("database error:".$conn->error);
while ($fila = $evalcomp_result->fetch_assoc()){
	$id = $fila['id'];
	$eliminar_evalcomp = "DELETE FROM evaluaciones_comp WHERE id = $id";
	$eliminar_evalcomp_result = $conn->query($eliminar_evalcomp) or die ("database error:".$conn->error);
	$eliminar_rescomp = "DELETE FROM resultados_comp WHERE evaluacion_id = $id";
	$eliminar_rescomp_result = $conn->query($eliminar_rescomp) or die ("database error:".$conn->error);
}
header("Location: procesos.php");
die();
?>
