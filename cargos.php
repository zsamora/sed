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
<h2>Cargos</h2>
<br>
<div class="container">
<div class="table-responsive">
  <?php
    $perfiles = "SELECT id, nombre
                   FROM perfiles
							 ORDER BY id";
    $perfiles_result = $conn->query($perfiles) or die("database error:". $conn->error);
   ?>
	<table class="table">
		<thead>
			<tr>
				<th>Agregar</th>
				<th>Cargo</th>
        <th>Perfil</th>
			</tr>
		</thead>
		<tbody>
			<form action='agregar14.php' method="post">
			<td>
				<div class="btn-group">
					<button type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-plus-sign"></span>
					</button>
				</div>
			</td>
			<td>
				<input type="text" name="cargo" class="form-control" placeholder="Cargo">
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
<?php
$cargos = "SELECT cargos.id as id, cargos.nombre as nombre, perfiles.nombre as perfil
             FROM cargos, perfiles
            WHERE perfiles.id = cargos.perfil_id
				 ORDER BY id";
$cargos_result = $conn->query($cargos) or die ("database error:".$conn->error);
?>
<div>
	<table class="table">
		<thead>
      <tr>
				<th>Acciones</th>
        <th>ID</th>
        <th>Cargo</th>
        <th>Perfil</th>
      </tr>
    </thead>
		<tbody>
			<?php while($fila = $cargos_result->fetch_assoc()){?>
			<tr>
				<td>
					<div class="btn-group">
						<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<?php echo "<li><a href='eliminar14.php?id_el=" . $fila["id"]. "'>Eliminar</a></li>"?>
						</ul>
					</div>
				</td>
			<?php
			echo "<td>" . $fila["id"] . "</td>";
			echo "<td>" . $fila["nombre"] . "</td>";
      echo "<td>" . $fila["perfil"] . "</td>";
    	echo "</tr>";
			} ?>
		</tbody>
	</table>
</div>
<br>
<h2>Asociar Cargo - Indicador</h2>
<br>
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Agregar</th>
				<th>Cargo</th>
				<th>Indicador</th>
			</tr>
		</thead>
		<tbody>
			<form action='agregar13.php' method="post">
			<td>
				<div class="btn-group">
					<button type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-plus-sign"></span>
					</button>
				</div>
			</td>
      <?php
        $indicadores = "SELECT id, descripcion FROM indicadores";
        $ind_result = $conn->query($indicadores) or die ("database error:".$conn->error);
        $cargos = "SELECT id, nombre FROM cargos";
        $cargos_result = $conn->query($cargos) or die ("database error:". $conn->error);
      ?>
			<td>
      <select name='cargo' class="custom-select mb-2 mr-sm-2 mb-sm-0">
			 <?php while($fila_cargos = $cargos_result->fetch_assoc()) {
				 echo "<option value=".$fila_cargos['id'].">".$fila_cargos['nombre']."</option>";
			 } ?>
			</select>
      </td>
      <td>
      <select name='ind' class="custom-select mb-2 mr-sm-2 mb-sm-0">
			 <?php while($fila_ind = $ind_result->fetch_assoc()) {
				 echo "<option value=".$fila_ind['id'].">".$fila_ind['id'].") ".$fila_ind['descripcion']."</option>";
			 } ?>
			</select>
      </td>
			</form>
		</tbody>
	</table>
</div>
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Acciones</th>
				<th>Cargo</th>
				<th>Indicador</th>
				<th>Ponderación</th>
			</tr>
		</thead>
		<tbody>
      <?php
        $indcargos = "SELECT indicadores.descripcion as ind, cargos.nombre as cargo, indicadores.ponderacion as pond,
                             indicadores.id as iid, cargos.id as cid
                      FROM indicador_cargos, indicadores, cargos
                      WHERE indicador_cargos.indicador_id = indicadores.id
                      AND indicador_cargos.cargo_id = cargos.id
								 ORDER BY cargo";
        $result = $conn->query($indcargos) or die ("database error:".$conn->error);
      while($fila = $result->fetch_assoc()) {
      ?>
      <tr>
				<td>
					<div class="btn-group">
						<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<?php echo "<li><a href='eliminar13.php?ind_id=" . $fila["iid"]. "&cargo_id=" . $fila["cid"]. "'>Eliminar</a></li>"?>
						</ul>
					</div>
				</td>
			<?php
				echo "<td>" . $fila["cargo"] . "</td>";
				echo "<td>" . $fila['iid']. ") ". $fila["ind"] . "</td>";
				echo "<td>" . $fila["pond"] . "%</td>";
    		echo "</tr>";
			} ?>
			<
		</tbody>
	</table>
</div>
</div>
<?php include('footer.php');?>
