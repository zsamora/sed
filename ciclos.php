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
<h2> Ciclos </h2>
<br>
<div class="container">
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Agregar</th>
				<th>Ciclo</th>
			</tr>
		</thead>
		<tbody>
			<form action='agregar16.php' method="post">
			<td>
				<div class="btn-group">
					<button type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-plus-sign"></span>
					</button>
				</div>
			</td>
			<td>
				<input type="text" name="ciclo" class="form-control" placeholder="Ciclo">
			</td>
			</form>
		</tbody>
	</table>
</div>
<?php
$ciclos = "SELECT id, nombre
						 FROM ciclos
				 ORDER BY id";
$ciclos_result = $conn->query($ciclos) or die ("database error:".$conn->error);
?>
<div>
	<table class="table">
		<thead>
      <tr>
				<th>Acciones</th>
        <th>ID</th>
        <th>Ciclo</th>
      </tr>
    </thead>
		<tbody>
			<?php while($fila = $ciclos_result->fetch_assoc()){?>
			<tr>
				<td>
					<div class="btn-group">
						<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<?php echo "<li><a href='eliminar16.php?id_el=" . $fila["id"]. "'>Eliminar</a></li>"?>
						</ul>
					</div>
				</td>
			<?php
			echo "<td>" . $fila["id"] . "</td>";
			echo "<td>" . $fila["nombre"] . "</td>";
    	echo "</tr>";
			} ?>
		</tbody>
	</table>
</div>
