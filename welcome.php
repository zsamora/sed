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
$pendientes = "SELECT id
								      FROM (SELECT (SELECT COUNT(*) FROM resultados_comp WHERE evaluacion_id IN (SELECT id FROM evaluaciones_comp WHERE evaluador_id = usuarios.id)) AS res,
								 							(SELECT COUNT(*) FROM evaluaciones_comp WHERE evaluador_id = usuarios.id AND proceso_id = 2) AS eval, usuarios.id as id
									            	 FROM usuarios) AS tablares
												WHERE eval!= res AND eval != 0
										UNION
									  SELECT id
									    FROM (SELECT (SELECT COUNT(*) FROM resultados_ind WHERE evaluacion_id IN (SELECT id FROM evaluaciones_ind WHERE evaluador_id = usuarios.id)) AS res,
																	(SELECT COUNT(*) FROM evaluaciones_ind WHERE evaluador_id = usuarios.id AND proceso_id = 2) AS eval, usuarios.id as id
															  		 FROM usuarios) AS tablares
																			WHERE eval!= res AND eval != 0";
$pendientes_result = $conn->query($pendientes);
$hab_esp = 0;
while($row = $pendientes_result->fetch_assoc())
{
	if ($id == $row["id"]) {
		$hab_esp = 1;
	}
}
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
		if ($fila["habilitado"] == 1 || $_SESSION['id'] == 1 || $_SESSION['id'] == 0) {
				echo "<td><a href='proceso.php?proceso_id=".$fila['id']."'>". $fila["nombre"] ."</a></td>";
				echo "<td>En Curso</td>";
		}
		elseif ($fila["habilitado"] == 2 && ($hab_esp || in_array($_SESSION['id'],array(0,1,41,152,101,149,49)))) {
				echo "<td><a href='proceso.php?proceso_id=".$fila['id']."'>". $fila["nombre"] ."</a></td>";
				echo "<td>Habilitado Especialmente</td>";
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
