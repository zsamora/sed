<?php
session_start();
if(!isset($_SESSION['id'])){
	header("Location: index.php");
}
$id = $_SESSION['id'];
//$_SESSION['proceso_id'] = 0; /*Proceso se hace cero cuando se ingresa a la pág de procesos*/
include('header.php');
include_once("db_connect.php");
$procesos = "SELECT DISTINCT  id, nombre, finicio, ftermino, habilitado
							 					FROM procesos, trabaja
											 WHERE trabaja.establecimiento_id = procesos.establecimiento_id
											 	 AND usuario_id = $id
									  ORDER BY id DESC";
$proc_result = $conn->query($procesos);
include('navbar.php');
?>
<div class="container">
	<?php include('sessionbar.php'); ?>
	<div class='alert'>
		<button class='close' data-dismiss='alert'>&times;</button>
		Bienvenid@ a la plataforma de evaluación. Seleccione un proceso para empezar
	</div>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
      <tr>
				<th>Nombre Proceso</th>
				<th>Estado</th>
        <th>Fecha de Inicio (año/mes/dia)</th>
        <th>Fecha de Término (año/mes/dia)</th>
      </tr>
    </thead>
		<tbody>
<?php while($fila = $proc_result->fetch_assoc()){
		echo "<tr>";
		if ($fila["habilitado"] || $_SESSION['id'] == 1 || $_SESSION['id'] == 0) {
				echo "<td><a href='proceso.php?proceso_id=".$fila['id']."'>". $fila["nombre"] ."</a></td>";
				echo "<td>En Curso</td>";
		}
		else {
			echo "<td>". $fila["nombre"] ."</a></td>";
			echo "<td>Cerrado</td>";
		}
    echo "<td>" . $fila["finicio"] . "</td>";
		echo "<td>" . $fila["ftermino"] . "</td>";
    echo "</tr>";
} ?>
  	</tbody>
	</table>
</div>
</div>
<?php include('footer.php');?>
