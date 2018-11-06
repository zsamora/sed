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
<h2> Indicadores </h2>
<br>
<div class="container">
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Agregar</th>
				<th>Meta (ID)</th>
				<th>Descripcion</th>
        <th>No Cumplido</th>
        <th>Mínimo</th>
        <th>Esperado</th>
        <th>Sobre lo esperado</th>
        <th>Ponderación</th>
			</tr>
		</thead>
		<tbody>
			<form action='agregar12.php' method="post">
			<td>
				<div class="btn-group">
					<button type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-plus-sign"></span>
					</button>
				</div>
			</td>
      <?php
        $metas = "SELECT *
                    FROM metas";
        $metas_result = $conn->query($metas) or die ("database error:".$conn->error);
      ?>
      <td>
      <select name='meta' class="custom-select mb-2 mr-sm-2 mb-sm-0">
			 <?php while($fila_metas = $metas_result->fetch_assoc()) {
				 echo "<option value=".$fila_metas['id'].">".$fila_metas['id']."</option>";
			 } ?>
			</select>
      </td>
      <td>
				<input type="text" name="descripcion" class="form-control" placeholder="Descripción">
			</td>
      <td>
				<input type="text" name="no_cumplido" class="form-control" placeholder="No Cumplido">
			</td>
      <td>
				<input type="text" name="minimo" class="form-control" placeholder="Mínimo">
			</td>
      <td>
				<input type="text" name="esperado" class="form-control" placeholder="Esperado">
			</td>
      <td>
				<input type="text" name="sobre_esperado" class="form-control" placeholder="Sobre lo esperado">
			</td>
      <td>
				<input type="number" name="ponderacion" class="form-control" placeholder="Ponderación">
			</td>
			</form>
		</tbody>
	</table>
</div>
<?php
$indicadores = "SELECT *
 									FROM indicadores
							ORDER BY meta_id ,id";
$ind_result = $conn->query($indicadores) or die ("database error:".$conn->error);
?>
<div>
	<table class="table table-hover">
		<thead>
      <tr>
				<th>Acciones</th>
        <th>Meta (ID)</th>
				<th>Indicador (ID)</th>
				<th>Descripción</th>
        <th>No Cumplido</th>
        <th>Mínimo</th>
        <th>Esperado</th>
        <th>Sobre lo esperado</th>
        <th>Ponderación</th>
      </tr>
    </thead>
		<tbody>
			<?php while($fila = $ind_result->fetch_assoc()){ ?>
			<tr>
				<td>
					<div class="btn-group">
						<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<?php echo "<li><a href='eliminar12.php?id_el=" . $fila["id"]. "'>Eliminar</a></li>"?>
						</ul>
					</div>
				</td>
			<?php
			echo "<td>" . $fila["meta_id"] . "</td>";
			echo "<td>" . $fila["id"] . "</td>";
      echo "<td>" . $fila["descripcion"] . "</td>";
      echo "<td>" . $fila["no_cumplido"] . "</td>";
      echo "<td>" . $fila["minimo"] . "</td>";
      echo "<td>" . $fila["esperado"] . "</td>";
      echo "<td>" . $fila["sobre_esperado"] . "</td>";
      echo "<td>" . $fila["ponderacion"] . "%</td>";
    	echo "</tr>";
			} ?>
		</tbody>
	</table>
</div>
</div>
<?php include('footer.php');?>
