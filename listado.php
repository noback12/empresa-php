<?php
	
	session_start();

	if(!isset($_SESSION['logueado'])) {
		header("Location: login.php");
		exit;
	}



	$cn = mysqli_connect("localhost", "root", "", "empresa");



	$empleados = mysqli_query($cn, "SELECT * 
									FROM empleados e
									LEFT JOIN cargos c on c.cargo_id=e.cargo_id");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Listado de Empleados</title>

	<style>
		table th, table td {
			border: 1px solid black;
		}
	</style>

</head>
<body>

	<p>Hola <?= $_SESSION['nombre'] ?></p>

	<form action="buscador.php" method="get">
		<label for="nombre">Buscar:</label>
		<input type="text" name="nombre" id="nombre" maxlength="20" />
		<input type="submit" value="Buscar" />
	</form>


	<h1>Listado de Empleados</h1>

	<table>
		<tr>
			<th>Empleado</th>
			<th>Cargo</th>
			<th>Monto total</th>
			<th>Adelantos</th>
		</tr>

		<?php while($fila = mysqli_fetch_assoc($empleados)) { ?>
			<tr>
				<td><a href="lista_ad.php?e=<?=$fila['empleado_id']?>"><?=$fila['nombre']?></a></td>
				<td><?=$fila['descripcion']?></td>
				<td></td>
				<td></td>
			</tr>
		<?php } ?>
	</table>

	<br/><br/>
	<a href="logout.php">Cerrar sesión</a>

</body>
</html>