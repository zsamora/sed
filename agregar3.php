<?php
include_once("db_connect.php");
$usuario=$_POST["usuario"];
$superior=$_POST["superior"];
$user = explode('-', $usuario);
$sup = explode('-', $superior);
$u_id = $user[0];
$u_pe = $user[1];
$u_ca = $user[2];
$u_ci = $user[3];
$u_as = $user[4];
$s_id = $sup[0];
$s_pe = $sup[1];
$s_ca = $sup[2];
$s_ci = $sup[3];
$s_as = $sup[4];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS, Y ARREGLAR ESTABLECIMIENTO
$agregar = "INSERT INTO `superiores_id`
                            VALUES ($u_id,$u_ca,$u_ci,$u_as,$s_id,$s_ca,$s_ci,$s_as)";
$opinantes1 = "INSERT INTO `opinantes`(`tipo_id`, `evaluado_id`, `perfil_id`, `cargo_id`, `ciclo_id`, `asignatura_id`, `evaluador_id`, `perfil_sup`, `cargo_sup`, `ciclo_sup`, `asignatura_sup`)
                 VALUES (2, $u_id, $u_pe, $u_ca, $u_ci, $u_as, $s_id, $s_pe, $s_ca, $s_ci, $s_as )";
$opinantes2 = "INSERT INTO `opinantes`(`tipo_id`, `evaluado_id`, `perfil_id`, `cargo_id`, `ciclo_id`, `asignatura_id`, `evaluador_id`, `perfil_sup`, `cargo_sup`, `ciclo_sup`, `asignatura_sup`)
                 VALUES (3, $s_id, $s_pe, $s_ca, $s_ci, $s_as, $u_id, $u_pe, $u_ca, $u_ci, $u_as)";
if ($conn->query($agregar) && $conn->query($opinantes1) && $conn->query($opinantes2)) {
  header("Location: superiores.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
