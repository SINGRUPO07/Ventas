<?php
include_once("./modelos/usuarioDto.php");
ob_start();
session_start();
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
	// var_dump($_POST);
	// exit();
	if ($valid) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT u.id, u.usuario, u.estado, u.tipo, u.local_id, l.nombre as clocal ";
		$sql.= " FROM usuario u left join local l on u.local_id=l.id WHERE u.usuario=? AND u.contrasena=? AND u.estado=1";
		$q = $pdo->prepare($sql);
		$q->execute(array($usuario, hash('sha3-512' , $contrasena)));
		$lUsuario = $q->fetchAll(PDO::FETCH_CLASS, "Usuario");
		Database::disconnect();
		if(count($lUsuario)>0) {
			$oUsuario = $lUsuario[0];
			if($oUsuario->estado==1) {
				$_SESSION['_usuario'] = $oUsuario;
				switch($oUsuario->tipo) {
					case 1:
						header("Location: admin");
					break;
					case 2:
						header("Location: ./");
					break;
				}
			} else {
				$contrasenaError = 'El usuario se encuentra inactivo';
			}
		} else {
			$contrasenaError = 'Datos de acceso no validos';
		}
	}
	include_once("login.php");
} else {
	header("Location: ./");
}
?>
