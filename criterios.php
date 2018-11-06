<?php
session_start();
if($_SESSION['id']!=1 && $_SESSION['id']!=0){ // Poner aquí las id de quien puede tener acceso
	header("Location: index.php");
}
$_SESSION['proceso_id'] = 0; /*Proceso se hace cero cuando se ingresa a la pág de procesos*/
include('header.php');
include_once("db_connect.php");
include('navbar.php');
?>
<div class="container">
	<?php include('sessionbar.php'); ?>
</div>
<h2> Criterios </h2>
<br>
<div class="container">
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
        <th>Acciones</th>
        <th>Descripción</th>
				<th>Mínimo</th>
        <th>En Desarrollo</th>
        <th>Desarrollado</th>
        <th>Superior</th>
        <th>Ponderación</th>
			</tr>
		</thead>
		<tbody>
			<form action='agregar9.php' method="post">
			<td>
				<div class="btn-group">
					<button type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-plus-sign"></span>
					</button>
				</div>
			</td>
			<td>
        <input style="height:100px;" type="text" name="descripcion" class="form-control" placeholder="Descripcion">
			</td>
			<td>
        <input style="height:100px;" type="text" name="minimo" class="form-control" placeholder="Mínimo">
			</td>
      <td>
        <input style="height:100px;" type="text" name="en_desarrollo" class="form-control" placeholder="En Desarrollo">
			</td>
      <td>
				<input style="height:100px;" type="text" name="desarrollado" class="form-control" placeholder="Desarrollado">
			</td>
      <td>
				<input style="height:100px;" type="text" name="superior" class="form-control" placeholder="Superior">
			</td>
      <td>
				<input type="number" name="ponderacion" class="form-control" placeholder="Ponderación">
			</td>
			</form>
		</tbody>
	</table>
</div>
<?php
$criterios = "SELECT id, descripcion, minimo, en_desarrollo, desarrollado, superior, ponderacion
								FROM criterios
						ORDER BY id";
$crit_result = $conn->query($criterios) or die ("database error:".$conn->error);
?>
<div>
	<table class="table table-hover">
		<thead>
      <tr>
				<th>Acciones</th>
        <th>ID</th>
        <th>Descripción</th>
				<th>Mínimo</th>
        <th>En Desarrollo</th>
        <th>Desarrollado</th>
        <th>Superior</th>
        <th>Ponderación</th>
      </tr>
    </thead>
		<tbody>
			<?php while($fila = $crit_result->fetch_assoc()){?>
			<tr>
				<td>
					<div class="btn-group">
						<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<?php echo "<li><a href='eliminar9.php?id_el=" . $fila["id"]. "'>Eliminar</a></li>"?>
						</ul>
					</div>
				</td>
			<?php
			echo "<td>" . $fila["id"] . "</td>";
			echo "<td>" . $fila["descripcion"] . "</td>";
      echo "<td>" . $fila["minimo"] . "</td>";
      echo "<td>" . $fila["en_desarrollo"] . "</td>";
      echo "<td>" . $fila["desarrollado"] . "</td>";
      echo "<td>" . $fila["superior"] . "</td>";
      echo "<td>" . $fila["ponderacion"] . "%</td>";
    	echo "</tr>";
			} ?>
		</tbody>
	</table>
</div>
<br>
<h2>Asociar Competencia - Criterio</h2>
<br>
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Agregar</th>
				<th>Competencia</th>
        <th>Criterio</th>
			</tr>
		</thead>
		<tbody>
			<form action='agregar10.php' method="post">
			<td>
				<div class="btn-group">
					<button type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-plus-sign"></span>
					</button>
				</div>
			</td>
			<?php
      $criterios = "SELECT id, descripcion
                     FROM criterios";
      $criterios_result = $conn->query($criterios) or die("database error:". $conn->error);
			$competencias = "SELECT id, nombre
												 FROM competencias";
      $comp_result = $conn->query($competencias) or die("database error:". $conn->error);
			?>
      <td>
				<select name='comp' class="custom-select mb-2 mr-sm-2 mb-sm-0">
				 <?php while($fila_comp = $comp_result->fetch_assoc()) {
					 echo "<option value=".$fila_comp['id'].">".$fila_comp['id'].") ".$fila_comp['nombre']."</option>";
				 } ?>
			 </select>
      </td>
      <td>
				<select name='crit' class="custom-select mb-2 mr-sm-2 mb-sm-0">
				 <?php while($fila_criterios = $criterios_result->fetch_assoc()) {
					 echo "<option value=".$fila_criterios['id'].">".$fila_criterios['id'].") ".$fila_criterios['descripcion']."</option>";
				 } ?>
			</td>
			</form>
		</tbody>
	</table>
</div>
<div>
	<table class="table table-hover">
		<thead>
      <tr>
				<th>Acciones</th>
    		<th>Competencia</th>
        <th>Criterio</th>
        <th>Ponderación</th>
      </tr>
    </thead>
		<tbody>
			<?php
			$comp_crit = "SELECT competencia_id, criterio_id, competencias.nombre as comp,
                           criterios.descripcion as crit, criterios.ponderacion as pond
												FROM comp_crit, competencias, criterios
											 WHERE comp_crit.competencia_id = competencias.id
											 	 AND comp_crit.criterio_id = criterios.id
                    ORDER BY competencia_id, criterio_id";
			$result = $conn->query($comp_crit) or die("database error:". $conn->error);
			while ($fila = $result->fetch_assoc()){
			?>
			<tr>
				<td>
					<div class="btn-group">
						<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<?php echo "<li><a href='eliminar10.php?comp_id=" . $fila["competencia_id"]. "&crit_id=" . $fila["criterio_id"]. "'>Eliminar</a></li>"?>
						</ul>
					</div>
				</td>
			<?php
				echo "<td>" . $fila["competencia_id"] .") ". $fila["comp"] . "</td>";
				echo "<td>" . $fila["criterio_id"].") ". $fila["crit"] . "</td>";
        echo "<td>" . $fila["pond"] . "%</td>";
    		echo "</tr>";
			} ?>
		</tbody>
	</table>
</div>
</div>
<?php include('footer.php');?>
