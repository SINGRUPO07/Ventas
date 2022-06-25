<?php
include_once("../modelos/usuarioDto.php");
if(isset($_COOKIE["PHPSESSID"])) session_id($_COOKIE["PHPSESSID"]);
ob_start();
session_start();
include_once("../modelos/tipopagoDto.php");
require_once("../database.php");
$oUsuario = isset($_SESSION['_usuario']) ? new Usuario($_SESSION['_usuario']) : null;
header('Content-Type: application/json; charset=utf-8');
// echo json_encode($_SERVER);
//if(!empty($oUsuario)) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$pdo = Database::connect();
		$metodo = $_SERVER["REQUEST_METHOD"];
		switch($metodo) {
			case 'GET':
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sWhere = "";
				$id = isset($_GET["id"]) ? $_GET["id"] : "";
				if(!empty($id)) {
					$sWhere = "Where id=?";
				}
				$sql = "SELECT id, nombre FROM tipopago " . $sWhere;
				$q = $pdo->prepare($sql);
				if(!empty($id)) {
					$q->execute(array($id));
				} else {
					$q->execute();
				}
				$lLocal = $q->fetchAll(PDO::FETCH_CLASS, "Local");
				echo json_encode(!empty($id) && count($lLocal)>0 ? $lLocal[0] : $lLocal);
				break;
			case "POST":
				if(!empty($oUsuario)) {
				} else {
					echo json_encode([ "resultado"=> [ "codigo"=> 1, "mensaje" => "No ha iniciado sesión" ]]);
				}
				break;
		}
		Database::disconnect();

	}
// } else {
// 	echo json_encode([ error=> [ codigo=> 1, mensaje => "No cuenta con acceso al contenido" ]]);
// }
?>
