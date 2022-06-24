<?php
include_once("../modelos/usuarioDto.php");
if(isset($_COOKIE["PHPSESSID"])) session_id($_COOKIE["PHPSESSID"]);
ob_start();
session_start();
include_once("./carritoDto.php");
include_once("./carritoDetalleDto.php");
require_once("../database.php");
$oUsuario = isset($_SESSION['_usuario']) ? new Usuario($_SESSION['_usuario']) : null;
header('Content-Type: application/json; charset=utf-8');
// echo json_encode($_SERVER);
$resultado=[ "resultado"=> [ "codigo"=> 0, "mensaje" => "El proceso se completo con exito" ]];
if(!empty($oUsuario)) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$pdo = Database::connect();
		$metodo = $_SERVER["REQUEST_METHOD"];
		switch($metodo) {
			case 'GET':
				if(!empty($oUsuario->id)) {
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "select id from carrito where usuario_id=? And estado=1";
					$q = $pdo->prepare($sql);
					$q->execute(array($oUsuario->id));
					$lCarrito = $q->fetchAll(PDO::FETCH_CLASS, "Carrito");
					$sCarrito = "";
					if(count($lCarrito)>0) {
						$sCarrito = $lCarrito[0]->id;
						$sql = "select cd.id, cd.producto_id, cd.cantidad, cd.fecha_registro, cd.estado, p.nombre cproducto, p.descripcion cdescripcion, p.precio ";
						$sql.= " from carrito_detalle cd ";
						$sql.= " left join producto p on cd.producto_id=p.id ";
						$sql.= " where cd.carrito_id=? and cd.estado=1";
						$q = $pdo->prepare($sql);
						$q->execute(array($sCarrito));
						$lCarritoDetalle = $q->fetchAll(PDO::FETCH_CLASS, "CarritoDetalle");
					}
					$resultado["datos"] = $lCarritoDetalle;
				}
				break;
			case "POST":
				if(!empty($oUsuario->local_id)) {
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$id = isset($_POST["id"]) ? $_POST["id"] : "";
					$accion = isset($_POST["accion"]) ? $_POST["accion"] : "";
					switch ($accion) {
						case 'AC':
							try {
	        			$pdo->beginTransaction();
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
								$sql.= " where carrito_id=? and producto_id=? and estado=1";
								$q = $pdo->prepare($sql);
								$q->execute(array($sCarrito, $id));
								$lCarritoD = $q->fetchAll(PDO::FETCH_CLASS, "CarritoDetalle");
								$sCarritoD = "";
								if(count($lCarritoD)<=0) {
									$sql = "insert into carrito_detalle (carrito_id, producto_id, cantidad, estado, fecha_registro) ";
									$sql.= " values( ?, ?, 1, 1, now())";
									$q = $pdo->prepare($sql);
									$q->execute(array($sCarrito, $id));
									$sCarritoD = $pdo->lastInsertId();
								} else {
									$sCarritoD = $lCarritoD[0]->id;
									$sql = "update carrito_detalle set cantidad=cantidad+1 where id=?";
									$q = $pdo->prepare($sql);
									$q->execute(array($sCarritoD));
								}
								$pdo->commit();
							} catch(PDOException $e) {
		            $pdo->rollBack();
								$resultado=[ "resultado"=> [ "codigo"=> 0, "mensaje" => "Se encontró un error en la ejecución",
									"mensaje_detalle"=> $e->getMessage()
								 ]];
					    }
							break;
						case 'QC':
							try {
	        			$pdo->beginTransaction();
								$sql = "select id from carrito where usuario_id=? And estado=1";
								$q = $pdo->prepare($sql);
								$q->execute(array($oUsuario->id));
								$lCarrito = $q->fetchAll(PDO::FETCH_CLASS, "Carrito");
								$sCarrito = "";
								if(count($lCarrito)>0) {
									$sCarrito = $lCarrito[0]->id;
									$sql = "delete from carrito_detalle ";
									$sql.= " where id=? and carrito_id=?";
									$q = $pdo->prepare($sql);
									$q->execute(array($id, $sCarrito));
								}
								$pdo->commit();
							} catch(PDOException $e) {
		            $pdo->rollBack();
								$resultado=[ "resultado"=> [ "codigo"=> 0, "mensaje" => "Se encontró un error en la ejecución",
									"mensaje_detalle"=> $e->getMessage()
								 ]];
					    }
							break;
						default:
							break;
					}
				} else {
					$resultado=[ "resultado"=> [ "codigo"=> 1, "mensaje" => "No ha iniciado sesión" ]];
				}
				break;
		}
		Database::disconnect();
	}
} else {
	$resultado = [ resultado=> [ codigo=> 1, mensaje => "No ha iniciado sesión" ]];
}
echo json_encode($resultado);
?>
