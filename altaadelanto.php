<?php
	$cn = mysqli_connect("localhost", "root", "", "empresa");

	if(count($_POST)>0) {  //estoy en la 2da ejecución

		//validación del id de empleado
		if(!isset($_POST['empleado'])) die("error1");
		if(!ctype_digit($_POST['empleado'])) die("error2");
		if($_POST['empleado']<1) die("error3");

		$aux = mysqli_query($cn, "SELECT * 
									FROM empleados
									WHERE empleado_id=".$_POST['empleado']." LIMIT 1");
		if(mysqli_num_rows($aux)!=1) die("error4");
		$eid = $_POST['empleado'];  //paso el dato a una variable limpia


		//validación del monto del adelanto
		if(!isset($_POST['monto'])) die("error5");
		if(!is_numeric($_POST['monto'])) die("error6");
		$monto = $_POST['monto'];



		if(isset($_POST['hoy'])) {
			mysqli_query($cn, "INSERT INTO adelantos
								(empleado_id, fecha, monto) 
								VALUES
								($eid, NOW(), $monto) ");

		} else {

			//validación de los componentes de la fecha
			if(!isset($_POST['dia'])) die("error7");
			if(!ctype_digit($_POST['dia'])) die("error8");
			if($_POST['dia']<1) die("error9");
			if($_POST['dia']>31) die("error10");
			$dia = $_POST['dia'];

			if(!isset($_POST['mes'])) die("error11");
			if(!ctype_digit($_POST['mes'])) die("error12");
			if($_POST['mes']<1) die("error13");
			if($_POST['mes']>12) die("error14");
			$mes = $_POST['mes'];

			if(!isset($_POST['anio'])) die("error15");
			if(!ctype_digit($_POST['anio'])) die("error16");
			if($_POST['anio'] > date("Y") ) die("error17");
			if($_POST['anio'] < (date("Y")-1) ) die("error18");
			$anio = $_POST['anio'];

			if(!checkdate($mes, $dia, $anio)) die("error19");

			mysqli_query($cn, "INSERT INTO adelantos
								(empleado_id, fecha, monto) 
								VALUES
								($eid, '$anio-$mes-$dia', $monto) ");

		}

	}

	$res = mysqli_query($cn, "SELECT *
						FROM empleados");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Alta de adelanto</title>
</head>
<body>
	<h1>Alta de adelanto</h1>

	<form action="" method="post">

		<label for="empleado">Quién:</label>
		<select name="empleado" id="empleado">
			<?php while($fila = mysqli_fetch_assoc($res)) { ?>
				<option value="<?= $fila['empleado_id']?>">
					<?= $fila['nombre']?>
				</option>
			<?php } ?>
		</select>

		<br/><br/>

		<label for="monto">Monto: $</label>
		<input type="text" name="monto" id="monto" />
		
		<br/><br/>
		<input type="checkbox" name="hoy" value="1" />

		<label for="d">Dia:</label>
		<input type="text" name="dia" id="d" />
		<label for="m">Mes:</label>
		<input type="text" name="mes" id="m" />
		<label for="a">Año:</label>
		<input type="text" name="anio" id="a" />


		<br/><br/>
		<input type="submit" value="Crear" />


	</form>

</body>
</html>