<?php
include_once("usuarioDto.php");
if(isset($_COOKIE["PHPSESSID"])) session_id($_COOKIE["PHPSESSID"]);
ob_start();
session_start();
include_once("../modelos/carritoDto.php");
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
				// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				// $sWhere = "";
				// $id = isset($_GET["id"]) ? $_GET["id"] : "";
				// if(!empty($id)) {
				// 	$sWhere = "Where id=?";
				// }
				// $sql = "SELECT id, usuario, estado, case when estado=1 then 'ACTIVO' else 'INACTIVO' end cestado, ";
				// $sql.= " tipo, case when tipo=1 then 'ADMINISTRADOR' else 'CLIENTE' end ctipo ";
				// $sql.= " FROM usuario " . $sWhere;
				// $q = $pdo->prepare($sql);
				// if(!empty($id)) {
				// 	$q->execute(array($id));
				// } else {
				// 	$q->execute();
				// }
				// $lUsuario = $q->fetchAll(PDO::FETCH_CLASS, "Usuario");
				// echo json_encode(!empty($id) && count($lUsuario)>0 ? $lUsuario[0] : $lUsuario);
				break;
			case "POST":
				if(!empty($oUsuario)) {
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$id = isset($_POST["id"]) ? $_POST["id"] : "";
					$accion = isset($_POST["accion"]) ? $_POST["accion"] : "";
					switch ($accion) {
						case 'AC':
							$sql = "select id, estado from carrito where usuario_id=? And estado=1";
							$q = $pdo->prepare($sql);
							$q->execute(array($oUsuario->id));
							$lCarrito = $q->fetchAll(PDO::FETCH_CLASS, "Carrito");
							$sCarrito = "";
							if(count($lCarrito)<=0) {
								$sql = "insert into carrito (usuario_id, fecha_registro, estado) values (?, now(), 1)";
								$q = $pdo->prepare($sql);
								$q->execute(array($oUsuario->id));
								$sCarrito = $pdo->lastInsertId();
							} else {
								$sCarrito = $lCarrito[0]->id;
							}
							$sql = "select id, producto_id, cantidad from carrito_detalle ";
							$sql.= " where carrito_id=? and producto_id=? and estado=1)";
							//$sql = "insert into carrito_detalle (carrito_id, producto_id, cantidad, estado)";
							$q = $pdo->prepare($sql);
							$q->execute(array($sCarrito, $id));
							$lCarritoD = $q->fetchAll(PDO::FETCH_CLASS, "CarritoDetalle");

							echo json_encode([ "resultado"=> [ "codigo"=> 0, "mensaje" => "El proceso se completo con exito" ]]);
							break;
						default:
							break;
					}
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
