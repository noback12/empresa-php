<?php

	session_start();

	if(!isset($_SESSION['logueado'])) {
		header("Location: login.php");
		exit;
	}

	$cn = mysqli_connect("localhost", "root", "", "empresa");


	if(!isset($_GET['e'])) die("error1");
	if(!ctype_digit($_GET['e'])) die("error2");
	if($_GET['e']<1) die("error3");

	$aux = mysqli_query($cn, "SELECT * 
								FROM empleados
								WHERE empleado_id=".$_GET['e']." LIMIT 1");
	if(mysqli_num_rows($aux)!=1) die("error4");

	$empleado = $_GET['e'];

	$adelantos = mysqli_query($cn, "SELECT *
									FROM adelantos
									WHERE empleado_id=$empleado");



?>
<!DOCTYPE html>
<html>
<head>
	<title>Listado de Adelantos</title>


	<style>
		table th, table td {
			border: 1px solid black;
		}
	</style>
</head>
<body>

	<h1>Listado de Adelantos</h1>

	<table>
		<tr>
			<th>Id</th>
			<th>Fecha</th>
			<th>Monto</th>
		</tr>

		<?php while($fila = mysqli_fetch_assoc($adelantos)) { ?>
			<tr>
				<td><?= $fila['adelanto_id'] ?></td>
				<td><?= $fila['fecha'] ?></td>
				<td><?= $fila['monto'] ?></td>
			</tr>
		<?php } ?>

	</table>

	<br/><br/>
	<a href="listado.php">Ir al listado</a>

</body>
</html>