<?php

	session_start();
	$cn = mysqli_connect("localhost", "root", "", "empresa");

	if(count($_POST) > 0) {

		// ---------  V A L I D A R !!!!!!!!!!!
		$email = $_POST['email'];
		$passwd = sha1($_POST['passwd']);
		// ---------  V A L I D A R !!!!!!!!!!!

		$res = mysqli_query($cn, "SELECT *
									FROM usuarios
									WHERE email='$email' and password='$passwd' 
									LIMIT 1");


		if(mysqli_num_rows($res) == 1) {
			$_SESSION['logueado'] = true;
			$fila = mysqli_fetch_assoc($res);
			$_SESSION['nombre'] = $fila['nombre'];
			header("Location: listado.php");
			exit;
		}

	}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Inicio de sesión</title>
</head>
<body>

	<form action="" method="post">
		<input type="text" name="email" /> <br/>
		<input type="password" name="passwd" /> <br/>

		<br/>
		<input type="submit" value="Iniciar sesión" />
	</form>

</body>
</html>