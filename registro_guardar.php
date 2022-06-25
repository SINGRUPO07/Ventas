<?php

	require 'database.php';

	if ( !empty($_POST)) {

		$usuarioError = null;
		$contrasenaError = null;
		$nombreError = null;
		$apellidoError = null;
		$correoError = null;
		$telefonoError = null;

		$usuario = $_POST['usuario'];
		$contrasena = $_POST['contrasena'];
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$correo = $_POST['correo'];
		$telefono = $_POST['telefono'];

		$valid = true;

		if (empty($usuario)) {
			$usuarioError = 'Por favor ingrese su nombre de usuario';
			$valid = false;
		}
		if (empty($contrasena)) {
			$contrasenaError = 'Por favor escribe su contrasena';
			$valid = false;
		}
		if (empty($nombre)) {
			$nombreError = 'Por favor escribe su nombre';
			$valid = false;
		}
		if (empty($apellido)) {
			$apellidoError = 'Por favor escribe su apellido';
			$valid = false;
		}
		if (empty($correo)) {
			$correoError = 'Por favor escribe su correo';
			$valid = false;
		}
		if (empty($telefono)) {
			$telefonoError = 'Por favor escribe su telefono';
			$valid = false;
		}

		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO usuario (usuario, contrasena, nombre, apellido, correo, telefono, fecha_registro, estado, tipo) ";
			$sql.= " values(?,?,?,?,?,?,NOW(),?,?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($usuario, hash('sha3-512' , $contrasena), $nombre, $apellido, $correo, $telefono, 1, 2));
			Database::disconnect();
			header("Location: login.php");
		}
		include_once("registrar.php");
	}
?>
