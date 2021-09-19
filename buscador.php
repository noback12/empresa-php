<?php

	$cn = mysqli_connect("localhost", "root", "", "empresa");

	if(!isset($_GET['nombre'])) die("error1");
	if(strlen($_GET['nombre'])<1) die("error2");
	//if(strlen($_GET['nombre']>20)) die("error3");  //opcion 1
	$_GET['nombre'] = substr($_GET['nombre'], 0, 20);  //opcion 2
	$_GET['nombre'] = mysqli_escape_string($cn, $_GET['nombre']);
	$_GET['nombre'] = str_replace('%', '\%', $_GET['nombre']);
	$_GET['nombre'] = str_replace('_', '\_', $_GET['nombre']);
	$nombre = $_GET['nombre'];

	$busq = mysqli_query($cn, "SELECT *
								FROM empleados
								WHERE nombre LIKE '%$nombre%'  ");
	$resultados = mysqli_num_rows($busq);


	if($resultados == 1) {
		//envio paquete 302 al usuario con la cabecera Location adecuada
		
		$datos = mysqli_fetch_assoc($busq);

		header("Location: lista_ad.php?e=" . $datos['empleado_id']);
		exit;

	}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Resultados de búsqueda</title>
</head>
<body>

	<?php if($resultados > 1) { ?>

		<?= $resultados?> encontrados: <br/><br/>

		<?php while($fila = mysqli_fetch_assoc($busq)) { ?>

			<p>
				<a href="lista_ad.php?e=<?=$fila['empleado_id']?>">
					<?=$fila['nombre']?>
				</a>
			</p>

		<?php } ?>


		<br/>
		<br/>
		<a href="listado.php">Volver</a>

	<?php } ?>


	<?php if($resultados == 0) { ?>

		<p>No existe "<?= htmlentities($_GET['nombre']) ?>"</p>

		<br/>
		<br/>
		<a href="listado.php">Volver</a>

	<?php } ?>

</body>
</html>