<?php
session_start();
if($_SESSION['id']!=1 && $_SESSION['id']!=0){ // Poner aquí las id de quien puede tener acceso
	header("Location: index.php");
}
include_once("db_connect.php");
$id_eliminar = $_GET['id_el'];
$eliminar = "DELETE FROM usuarios WHERE id = $id_eliminar";
$eliminar_result = $conn->query($eliminar) or die ("database error:".$conn->error);
$eliminar_trabajo = "DELETE FROM trabaja WHERE usuario_id = $id_eliminar";
$eliminar_trabajo_result = $conn->query($eliminar_trabajo) or die ("database error:".$conn->error);
$eliminar_superiores = "DELETE FROM superiores_id WHERE usuario_id = $id_eliminar OR superior_id = $id_eliminar";
$eliminar_superiores_result = $conn->query($eliminar_superiores) or die ("database error:".$conn->error);
$eliminar_opinantes = "DELETE FROM opinantes WHERE evaluado_id = $id_eliminar OR evaluador_id = $id_eliminar";
$eliminar_opinantes_result = $conn->query($eliminar_opinantes) or die ("database error:".$conn->error);
$evalcomp = "SELECT id FROM evaluaciones_comp WHERE evaluado_id = $id_eliminar OR evaluador_id = $id_eliminar";
$evalcomp_result = $conn->query($evalcomp) or die ("database error:".$conn->error);
$evalind = "SELECT id FROM evaluaciones_ind WHERE evaluado_id = $id_eliminar OR evaluador_id = $id_eliminar";
$evalind_result = $conn->query($evalind) or die ("database error:".$conn->error);
// Preguntar si se quieren eliminar los resultados también y comentar esas líneas
while ($fila = $evalcomp_result->fetch_assoc()){
	$id = $fila['id'];
	$eliminar_evalcomp = "DELETE FROM evaluaciones_comp WHERE id = $id";
	$eliminar_evalcomp_result = $conn->query($eliminar_evalcomp) or die ("database error:".$conn->error);
	$eliminar_rescomp = "DELETE FROM resultados_comp WHERE evaluacion_id = $id";
	$eliminar_rescomp_result = $conn->query($eliminar_rescomp) or die ("database error:".$conn->error);
}
while ($fila = $evalind_result->fetch_assoc()){
	$id = $fila['id'];
	$eliminar_evalind = "DELETE FROM evaluaciones_ind WHERE id = $id";
	$eliminar_evalind_result = $conn->query($eliminar_evalind) or die ("database error:".$conn->error);
	$eliminar_resind = "DELETE FROM resultados_ind WHERE evaluacion_id = $id";
	$eliminar_resind_result = $conn->query($eliminar_resind) or die ("database error:".$conn->error);
}
header("Location: usuarios.php");
die();
?>
