<?php
include_once("../modelos/usuarioDto.php");
if(isset($_COOKIE["PHPSESSID"])) session_id($_COOKIE["PHPSESSID"]);
ob_start();
session_start();
include_once("../modelos/localDto.php");
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
				$sql = "SELECT id, nombre FROM local " . $sWhere;
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
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$id = isset($_POST["id"]) ? $_POST["id"] : "";
					$accion = isset($_POST["accion"]) ? $_POST["accion"] : "";
					switch ($accion) {
						case 'SL':
							$sql = "Update usuario set local_id=? where id=? ";
							$q = $pdo->prepare($sql);
							$q->execute(array($id, $oUsuario->id));
							//$_SESSION['_usuario']
							echo json_encode([ "resultado"=> [ "codigo"=> 0, "mensaje" => "El proceso se completo con exito" ]]);
							break;
						default:
							break;
					}
				}
				break;
		}
		Database::disconnect();

	}
// } else {
// 	echo json_encode([ error=> [ codigo=> 1, mensaje => "No cuenta con acceso al contenido" ]]);
// }
?>
