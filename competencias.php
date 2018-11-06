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
<h2> Competencias </h2>
<br>
<div class="container">
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Agregar</th>
				<th>Nombre</th>
				<th>Descripcion</th>
			</tr>
		</thead>
		<tbody>
			<form action='agregar4.php' method="post">
			<td>
				<div class="btn-group">
					<button type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-plus-sign"></span>
					</button>
				</div>
			</td>
			<td>
				<input type="text" name="nombre" class="form-control" placeholder="Competencia">
			</td>
			<td>
				<input type="text" name="descripcion" class="form-control" placeholder="Descripcion">
			</td>
			</form>
		</tbody>
	</table>
</div>
<?php
$competencias = "SELECT id, nombre, descripcion
									 FROM competencias";
$comp_result = $conn->query($competencias) or die ("database error:".$conn->error);
?>
<div>
	<table class="table table-hover">
		<thead>
      <tr>
				<th>Acciones</th>
        <th>ID</th>
				<th>Nombre</th>
        <th>Descripción</th>
      </tr>
    </thead>
		<tbody>
			<?php while($fila = $comp_result->fetch_assoc()){?>
			<tr>
				<td>
					<div class="btn-group">
						<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<?php echo "<li><a href='eliminar4.php?id_el=" . $fila["id"]. "'>Eliminar</a></li>"?>
						</ul>
					</div>
				</td>
			<?php
			echo "<td>" . $fila["id"] . "</td>";
			echo "<td>" . $fila["nombre"] . "</td>";
			echo "<td>" . $fila["descripcion"] . "</td>";
    	echo "</tr>";
			} ?>
		</tbody>
	</table>
</div>
<h2>Asociar Competencia - Perfil</h2>
<br>
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Agregar</th>
				<th>Competencia</th>
				<th>Perfil</th>
			</tr>
		</thead>
		<tbody>
			<form action='agregar7.php' method="post">
			<td>
				<div class="btn-group">
					<button type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-plus-sign"></span>
					</button>
				</div>
			</td>
			<?php
			$competencias = "SELECT id, nombre
												 FROM competencias";
      $comp_result = $conn->query($competencias) or die("database error:". $conn->error);
			$perfiles = "SELECT id, nombre
										 FROM perfiles";
			$perfiles_result = $conn->query($perfiles) or die("database error:". $conn->error);
			?>
			<td>
				<select name='comp' class="custom-select mb-2 mr-sm-2 mb-sm-0">
				 <?php while($fila_comp = $comp_result->fetch_assoc()) {
					 echo "<option value=".$fila_comp['id'].">" . $fila_comp["id"].") ".$fila_comp['nombre']."</option>";
				 } ?>
			 </select>
			</td>
			<td>
				<select name='perf' class="custom-select mb-2 mr-sm-2 mb-sm-0">
				 <?php while($fila_perfiles = $perfiles_result->fetch_assoc()) {
					 echo "<option value=".$fila_perfiles['id'].">".$fila_perfiles['nombre']."</option>";
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
        <th>Perfil</th>
      </tr>
    </thead>
		<tbody>
			<?php
			$comp_perfil = "SELECT competencia_id, perfil_id, competencias.nombre as comp, perfiles.nombre as perf
												FROM comp_perfiles, competencias, perfiles
											 WHERE comp_perfiles.competencia_id = competencias.id
											 	 AND comp_perfiles.perfil_id = perfiles.id
										ORDER BY competencia_id";
			$result = $conn->query($comp_perfil) or die("database error:". $conn->error);
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
							<?php echo "<li><a href='eliminar7.php?comp_id=" . $fila["competencia_id"]. "&perf_id=" . $fila["perfil_id"]. "'>Eliminar</a></li>"?>
						</ul>
					</div>
				</td>
			<?php
				echo "<td>" . $fila["competencia_id"].") ".$fila["comp"] . "</td>";
				echo "<td>" . $fila["perf"] . "</td>";
    		echo "</tr>";
			} ?>
		</tr>
		</tbody>
	</table>
</div>
</div>
<?php include('footer.php');?>
