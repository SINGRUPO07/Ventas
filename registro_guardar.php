<?php

	require 'database.php';

	if ( !empty($_POST)) {

		$usuarioError = null;
		$contrasenaError = null;

		$usuario = $_POST['usuario'];
		$contrasena = $_POST['contrasena'];

		$valid = true;

		if (empty($usuario)) {
			$usuarioError = 'Por favor ingrese su nombre de usuario';
			$valid = false;
		}
		if (empty($contrasena)) {
			$contrasenaError = 'Por favor escribe su contrasena';
			$valid = false;
		}

		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'INSERT INTO usuario (usuario, contrasena, fecha_registro, estado, tipo) values(?,?,NOW(),?,?)';
			$q = $pdo->prepare($sql);
			$q->execute(array($usuario, hash('sha3-512' , $contrasena), 0, 0));
			Database::disconnect();
			header("Location: login.php");
		}
		include_once("registrar.php");
	}
?>
