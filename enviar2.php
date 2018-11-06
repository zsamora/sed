<?php
session_start();
include_once("db_connect.php");
$ids = $_POST['id_result'];
$selecciones = $_POST['seleccion_result'];
for ($i = 0 ; $i < count($ids) ; $i++){
      $eval_id = $ids[$i];
      $sel_id = $selecciones[$i];
      $existe_sql = "SELECT * FROM resultados_comp WHERE evaluacion_id = $eval_id";
      $existe_result = $conn->query($existe_sql) or die("database error:". $conn->error);
      if ($existe_result->num_rows == 0){
        $insertar_sql ="INSERT INTO resultados_comp (evaluacion_id,respuesta) VALUES ($eval_id,$sel_id)";
        $insertar_result = $conn->query($insertar_sql) or die ("database error:". $conn->error);
      }
      else {
      $update_sql = "UPDATE resultados_comp SET respuesta = $sel_id WHERE evaluacion_id = $eval_id";
      $update_result = $conn->query($update_sql) or die ("database error:". $conn->error);
      }
}
?>
