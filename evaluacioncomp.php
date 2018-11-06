<?php
session_start();
$_SESSION['eval_id'] = $_GET['eval_id'];
$_SESSION['car_id'] = $_GET['car_id'];
$_SESSION['cic_id'] = $_GET['cic_id'];
$_SESSION['asi_id'] = $_GET['asi_id'];
$_SESSION['car2_id'] = $_GET['car2_id'];
$_SESSION['cic2_id'] = $_GET['cic2_id'];
$_SESSION['asi2_id'] = $_GET['asi2_id'];
$_SESSION['tipo_eval'] = $_GET['tipo_eval'];
if(!isset($_SESSION['id'])){
	header("Location: index.php");
}
if(!isset($_SESSION['proceso_id']) || !isset($_SESSION['eval_id']) ||
	 !isset($_SESSION['car_id']) || !isset($_SESSION['cic_id']) ||
	 !isset($_SESSION['asi2_id']) || !isset($_SESSION['asi2_id']) ||
	 !isset($_SESSION['car2_id']) || !isset($_SESSION['cic2_id'] )){
	header("Location: welcome.php");
}
include('header.php');
include_once("db_connect.php");
include('navbar.php');
$proceso = $_SESSION['proceso_id'];
$tipo_eval = $_SESSION['tipo_eval'];
$evaluador = $_SESSION['id'];
// Nombre evaluado
$evaluado = $_SESSION['eval_id'];
$evaluado_nombre = "SELECT nombre, apellidop
										FROM usuarios
										WHERE id = $evaluado";
$evaluado_result = $conn->query($evaluado_nombre) or die("database error:". $conn->error);
$evaluado_row = $evaluado_result->fetch_assoc();
// Cargos Evaluado y Evaluador
$evaluado_cargo = $_SESSION['car_id'];
$evaluador_cargo = $_SESSION['car2_id'];
$cargos = "SELECT c1.nombre as cargo1, c2.nombre as cargo2
					 FROM cargos c1, cargos c2
					 WHERE c1.id = $evaluado_cargo
					 AND c2.id = $evaluador_cargo";
$cargo_res = $conn->query($cargos) or die("database error:". $conn->error);
$cargo_row = $cargo_res->fetch_assoc();
// Ciclos Evaluado y Evaluador
$evaluado_ciclo = $_SESSION['cic_id'];
$evaluador_ciclo = $_SESSION['cic2_id'];
$ciclos = "SELECT c1.nombre as ciclo1, c2.nombre as ciclo2
					 FROM ciclos c1, ciclos c2
					 WHERE c1.id = $evaluado_ciclo
					 AND c2.id = $evaluador_ciclo";
$ciclo_res = $conn->query($ciclos) or die("database error:". $conn->error);
$ciclo_row = $ciclo_res->fetch_assoc();
// Asignatura
$evaluado_asig = $_SESSION['asi_id'];
$evaluador_asig = $_SESSION['asi2_id'];
$asignaturas = "SELECT a1.nombre as asignatura1, a2.nombre as asignatura2
					 FROM asignaturas a1, asignaturas a2
					 WHERE a1.id = $evaluado_asig
					 AND a2.id = $evaluador_asig";
$asignatura_res = $conn->query($asignaturas) or die("database error:". $conn->error);
$asignatura_row = $asignatura_res->fetch_assoc();
// Tipo
$tipo = "SELECT nombre
					 FROM evaluacion_tipo
					 WHERE id = $tipo_eval";
$tipo_res = $conn->query($tipo) or die("database error:". $conn->error);
$tipo_row = $tipo_res->fetch_assoc();
?>

<div class="container">
	<?php include('sessionbar.php'); ?>
	<h2> Evaluación de Competencia </h2>
	<br>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th> Tipo de Evaluación </th>
					<th id='desc'> Evaluado </th>
					<th id='desc'> Cargo </th>
					<th id='desc'> Ciclo </th>
					<th id='desc'> Asignatura </th>
	        <th> Evaluador </th>
					<th> Cargo </th>
					<th> Ciclo </th>
					<th> Asignatura </th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php
					echo "<td>" . $tipo_row["nombre"] . "</td>";
					echo "<td>" . $evaluado_row["nombre"] . " " . $evaluado_row["apellidop"] . "</td>";
					echo "<td>" . $cargo_row['cargo1']. "</td>";
					echo "<td>" . $ciclo_row["ciclo1"] . "</td>";
					echo "<td>" . $asignatura_row['asignatura1'] . "</td>";
					echo "<td>" . $_SESSION["nombre"] . " " . $_SESSION["apellidop"] ." (yo) </td>";
					echo "<td>" . $cargo_row["cargo2"] . "</td>";
					echo "<td>" . $ciclo_row["ciclo2"] . "</td>";
					echo "<td>" . $asignatura_row['asignatura2'] . "</td>";
					?>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
	// Competencias
	$comp = "SELECT DISTINCT competencia_id, nombre, descripcion
											FROM evaluaciones_comp, competencias
											WHERE proceso_id = $proceso
											AND evaluado_id = $evaluado
											AND cargo_id = $evaluado_cargo
											AND ciclo_id = $evaluado_ciclo
											AND asignatura_id = $evaluado_asig
											AND evaluador_id = $evaluador
											AND cargo_sup = $evaluador_cargo
											AND ciclo_sup = $evaluador_ciclo
											AND asignatura_sup = $evaluador_asig
											AND tipo_id = $tipo_eval
											AND competencias.id = competencia_id
								 ORDER BY competencia_id";
	$comp_result = $conn->query($comp) or die("database error:". $conn->error);
	while($fila_comp = $comp_result->fetch_assoc()){ ?>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th id='desc'> Competencia </th>
						<th> Descripción </th>
					</tr>
				</thead>
				<tbody>
				<?php
					$comp_id = $fila_comp['competencia_id'];
					$comp_nombre = $fila_comp['nombre'];
					$comp_desc = $fila_comp['descripcion'];
					echo "<tr>";
					echo "<td> N°".$comp_id.": ".$comp_nombre."</td>";
					echo "<td>".$comp_desc."</td>";
					echo "</tr>"; ?>
				</tbody>
			</table>
		</div>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th id='desc'> Criterios </th>
					<th> Mínimo </th>
					<th> En Desarrollo </th>
	        <th> Desarrollado </th>
					<th> Superior </th>
					<th> Ponderación </th>
					<th> Porcentaje </th>
				</tr>
			</thead>
			<tbody>
		<form action="" method="post" id="send-form">
			<?php
			// Criterios
			$crit = "SELECT id, criterio_id
							  FROM evaluaciones_comp
								WHERE proceso_id = $proceso
								AND evaluado_id = $evaluado
								AND cargo_id = $evaluado_cargo
								AND ciclo_id = $evaluado_ciclo
								AND asignatura_id = $evaluado_asig
								AND evaluador_id = $evaluador
								AND cargo_sup = $evaluador_cargo
								AND ciclo_sup = $evaluador_ciclo
								AND asignatura_sup = $evaluador_asig
								AND tipo_id = $tipo_eval
								AND competencia_id = $comp_id
					 ORDER BY criterio_id";
			$crit_result = $conn->query($crit) or die("database error:". $conn->error);
			while($fila_crit = $crit_result->fetch_assoc()){
				$eval_id = $fila_crit['id'];
				$crit_id = $fila_crit['criterio_id'];
				// Descripcion
				$info = "SELECT criterios.descripcion as crit_desc,
												minimo, en_desarrollo, desarrollado, superior, ponderacion
									FROM criterios
									WHERE criterios.id = $crit_id";
				$info_result = $conn->query($info) or die("database error:". $conn->error);
				$info_row = $info_result->fetch_assoc();
				$resultado = "SELECT respuesta FROM resultados_comp WHERE evaluacion_id = $eval_id";
				$resultado_result = $conn->query($resultado) or die("database error:". $conn->error);
				$estado = $resultado_result->num_rows;
				if ($estado == 1) {
					$resultado_row = $resultado_result->fetch_assoc();
					echo "<tr>";
					echo "<td> N°".$crit_id.": ".$info_row["crit_desc"]."</td>";
					// Primer cuadro
					if ($resultado_row['respuesta'] == 1) {
						echo "<td id='select' style='background-color:lightblue'><input type='radio' name='".$eval_id."' value ='1' checked='checked'>" . $info_row["minimo"]."</td>";
						echo "<td id='select'><input type='radio' name='".$eval_id."' value ='2'>" . $info_row["en_desarrollo"]."</td>";
						echo "<td id='select'><input type='radio' name='".$eval_id."' value ='3'>" . $info_row["desarrollado"]."</td>";
						echo "<td id='select'><input type='radio' name='".$eval_id."' value ='4'>" . $info_row["superior"]."</td>";
						echo "<td>". $info_row["ponderacion"]."%</td>";
						echo "<td id='porcentaje'> 33.33%</td>";
					}
					// Segundo cuadro
					else if ($resultado_row['respuesta'] == 2) {
						echo "<td id='select'><input type='radio' name='".$eval_id."' value ='1'>" . $info_row["minimo"]."</td>";
						echo "<td id='select' style='background-color:lightblue'><input type='radio' name='".$eval_id."' value ='2' checked='checked'>" . $info_row["en_desarrollo"]."</td>";
						echo "<td id='select'><input type='radio' name='".$eval_id."' value ='3'>" . $info_row["desarrollado"]."</td>";
						echo "<td id='select'><input type='radio' name='".$eval_id."' value ='4'>" . $info_row["superior"]."</td>";
						echo "<td>". $info_row["ponderacion"]."%</td>";
						echo "<td id='porcentaje'> 66.67%</td>";
					}
					// Tercer cuadro
					else if ($resultado_row['respuesta'] == 3) {
						echo "<td id='select'><input type='radio' name='".$eval_id."' value ='1'>" . $info_row["minimo"]."</td>";
						echo "<td id='select'><input type='radio' name='".$eval_id."' value ='2'>" . $info_row["en_desarrollo"]."</td>";
						echo "<td id='select' style='background-color:lightblue'><input type='radio' name='".$eval_id."' value ='3' checked='checked'>" . $info_row["desarrollado"]."</td>";
						echo "<td id='select'><input type='radio' name='".$eval_id."' value ='4'>" . $info_row["superior"]."</td>";
						echo "<td>". $info_row["ponderacion"]."%</td>";
						echo "<td id='porcentaje'> 100.00%</td>";
					}
					// Cuarto cuadro
					else if ($resultado_row['respuesta'] == 4) {
						echo "<td id='select'><input type='radio' name='".$eval_id."' value ='1'>" . $info_row["minimo"]."</td>";
						echo "<td id='select'><input type='radio' name='".$eval_id."' value ='2'>" . $info_row["en_desarrollo"]."</td>";
						echo "<td id='select'><input type='radio' name='".$eval_id."' value ='3'>" . $info_row["desarrollado"]."</td>";
						echo "<td id='select' style='background-color:lightblue'><input type='radio' name='".$eval_id."' value ='4' checked='checked'>" . $info_row["superior"]."</td>";
						echo "<td>". $info_row["ponderacion"]."%</td>";
						echo "<td id='porcentaje'> 133.33%</td>";
					}
				}
				else {
					echo "<tr>";
					echo "<td> N°".$crit_id.": ".$info_row["crit_desc"]."</td>";
					echo "<td id='select'><input type='radio' name='".$eval_id."' value ='1'>" . $info_row["minimo"]."</td>";
					echo "<td id='select'><input type='radio' name='".$eval_id."' value ='2'>" . $info_row["en_desarrollo"]."</td>";
					echo "<td id='select'><input type='radio' name='".$eval_id."' value ='3'>" . $info_row["desarrollado"]."</td>";
					echo "<td id='select'><input type='radio' name='".$eval_id."' value ='4'>" . $info_row["superior"]."</td>";
					echo "<td>". $info_row["ponderacion"]."%</td>";
					echo "<td id='porcentaje'> %</td>";
				}
				echo "</tr>";
				} ?>
			</tbody>
		</table>
	</div>
	<?php } ?>
	<br>
		<div class="form-group">
			<center>
				<button type="submit" class="btn btn-default" name="send_button2" id="send_button2">
					<span class="glyphicon glyphicon-send"></span> &nbsp; Enviar Resultados (Guardar)
				</button>
			</center>
		</div>
	</form>
	</div>
	<?php include('footer.php');?>
	<script type="text/javascript">
		$('td#select').click(function(){
			$(this).css('background-color','lightblue');
			$(this).siblings().css( "background-color",'white');
			$(this).find('input').prop('checked',true);
			var siblings = $(this).siblings();
			var value = $(this).find('input').attr('value');
			if (value == 1) {
					siblings[5].innerHTML = "33.33%";
			}
			else if (value == 2) {
					siblings[5].innerHTML = "66.67%";
			}
			else if (value == 3) {
					siblings[5].innerHTML = "100.00%";
			}
			else {
					siblings[5].innerHTML = "133.33%";
			}
		});
		$('#send_button2').click(function() {
	    var val = $('input:checked').serialize();
	    var elements = val.split("&");
	    var id_result = [];
	    var seleccion_result = [];
			var proceso = <?php echo $proceso; ?>;
	    for (var i = 0; i < elements.length; i++){
	      var x = elements[i].split("=");
	      id_result.push(parseInt(x[0]));
	      seleccion_result.push(parseInt(x[1]));
	    }
	    if (elements.length >= 1 && elements[0] != "") {
	      $.ajax({
	        type : 'POST',
	        url  : 'enviar2.php',
	        data : {id_result: id_result, seleccion_result: seleccion_result},
					async: false
	        /*success : function(response){
	          console.log(response);
						proceso = 0;
	          //window.location.replace("proceso.php?proceso_id="+response);
	        }*/
	      	}).done(function() {
	        	window.location.replace("proceso.php?proceso_id="+proceso);
    		});
	    }
	    else {
	      console.log("No se ha enviado información");
	    }
	  });
	</script>
