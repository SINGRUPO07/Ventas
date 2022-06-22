<?php
include_once("usuarioDto.php");
ob_start();
session_start();
require_once("../../database.php");
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
				$sql = "SELECT id, usuario, estado, case when estado=1 then 'ACTIVO' else 'INACTIVO' end cestado, ";
				$sql.= " tipo, case when tipo=1 then 'ADMINISTRADOR' else 'CLIENTE' end ctipo ";
				$sql.= " FROM usuario " . $sWhere;
				$q = $pdo->prepare($sql);
				if(!empty($id)) {
					$q->execute(array($id));
				} else {
					$q->execute();
				}
				$lUsuario = $q->fetchAll(PDO::FETCH_CLASS, "Usuario");
				echo json_encode(!empty($id) && count($lUsuario)>0 ? $lUsuario[0] : $lUsuario);
				break;
			case "POST":
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$id = isset($_POST["id"]) ? $_POST["id"] : "";
				$accion = isset($_POST["accion"]) ? $_POST["accion"] : "";
				switch ($accion) {
					case 'CE':
						$sql = "Update usuario set estado=(case when estado=0 then 1 else 0 end) where id=? ";
						$q = $pdo->prepare($sql);
						$q->execute(array($id));
						echo json_encode([ "resultado"=> [ "codigo"=> 0, "mensaje" => "El proceso se completo con exito" ]]);
						break;
					default:
						break;
				}
				break;
		}
		Database::disconnect();

	}
// } else {
// 	echo json_encode([ error=> [ codigo=> 1, mensaje => "No cuenta con acceso al contenido" ]]);
// }
?>
