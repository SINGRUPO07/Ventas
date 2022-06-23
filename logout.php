<?php
include_once("modelos/usuarioDto.php");
require 'database.php';
session_start();
$oUsuario = isset($_SESSION['_usuario']) ? $_SESSION['_usuario'] : null;
if(!empty($oUsuario)) {
	$_SESSION = array();
	if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
	}

	session_destroy();
	header("Location: ./");
}

?>
