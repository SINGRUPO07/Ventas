<?php
include_once("../modelos/usuarioDto.php");
if(isset($_COOKIE["PHPSESSID"])) session_id($_COOKIE["PHPSESSID"]);
ob_start();
session_start();
include_once("../carrito/carritoDto.php");
include_once("./pedidoDto.php");
include_once("./pedidoDetalleDto.php");
require_once("../database.php");
$oUsuario = isset($_SESSION['_usuario']) ? new Usuario($_SESSION['_usuario']) : null;
header('Content-Type: application/json; charset=utf-8');
$resultado=[ "resultado"=> [ "codigo"=> 0, "mensaje" => "El proceso se completo con exito" ]];
if(!empty($oUsuario)) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$pdo = Database::connect();
		$metodo = $_SERVER["REQUEST_METHOD"];
		switch($metodo) {
			case 'GET':
				if(!empty($oUsuario->id)) {
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "select v.id, v.usuario_id, v.local_id, v.tipopago_id, v.monto_total, v.fecha_registro, v.estado, ";
					$sql.= " concat(u.apellido,', ',u.nombre) cusuario, l.nombre clocal, tp.nombre ctipopago, ";
					$sql.= " case when v.estado=1 then 'REGISTRADO' when v.estado=2 then 'ENTREGADO' when v.estado=3 then 'ANULADO' end cestado ";
					$sql.= " from venta v left join usuario u on v.usuario_id=u.id";
					$sql.= " left join local l on v.local_id=l.id";
					$sql.= " left join tipopago tp on v.tipopago_id=tp.id";
					$sql.= ($oUsuario->tipo!=1 ? " where v.usuario_id=?" : "");
					$q = $pdo->prepare($sql);
					if($oUsuario->tipo!=1) $q->execute(array($oUsuario->id));
					else $q->execute();
					$lVenta = $q->fetchAll(PDO::FETCH_CLASS, "Pedido");
					$resultado["datos"] = $lVenta;
				}
				break;
			case "POST":
				if(!empty($oUsuario->local_id)) {
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$id = isset($_POST["id"]) ? $_POST["id"] : "";
					$tipopago_id = isset($_POST["tipopago_id"]) ? $_POST["tipopago_id"] : "";
					$accion = isset($_POST["accion"]) ? $_POST["accion"] : "";
					switch ($accion) {
						case 'GP':	// Generar Pedido
							if(!empty($oUsuario->local_id)) {
								if(!empty($tipopago_id)) {
									$sql = "select id from carrito where usuario_id=? And estado=1";
									$q = $pdo->prepare($sql);
									$q->execute(array($oUsuario->id));
									$lCarrito = $q->fetchAll(PDO::FETCH_CLASS, "Carrito");
									$sCarrito = "";
									if(count($lCarrito)>0) {
										try {
				        			$pdo->beginTransaction();
											$sCarrito=$lCarrito[0]->id;
											$sql = "insert into venta (usuario_id, local_id, tipopago_id, fecha_registro, estado) ";
											$sql.= " values (:usuario_id, :local_id, :tipopago_id, now(), 0)";
											$q = $pdo->prepare($sql);
											$q->execute([":usuario_id"=>$oUsuario->id, ":local_id"=>$oUsuario->local_id, ":tipopago_id"=>$tipopago_id]);
											$iVenta = $pdo->lastInsertId();
											// Copiar detalles de Carrito a Pedido
											$sql = "insert into venta_detalle (venta_id, producto_id, cantidad, precio, importe, estado, fecha_registro) ";
											$sql.= " select :venta_id, cd.producto_id, cd.cantidad, p.precio, cd.cantidad*p.precio, 1, now() from ";
											$sql.= " carrito_detalle cd left join producto p on cd.producto_id=p.id ";
											$sql.= " where carrito_id=:carrito_id ";
											$q = $pdo->prepare($sql);
											$q->execute([":venta_id"=>$iVenta, ":carrito_id"=>$sCarrito]);
											// Actualizar importe total y estado
											$sql = " update venta v set monto_total= (select sum(importe) from venta_detalle vd where vd.venta_id=v.id), ";
											$sql.= " v.estado=1 ";
											$sql.= " where v.id=:venta_id ";
											$q = $pdo->prepare($sql);
											$q->execute([":venta_id"=>$iVenta]);
											// Actualizar el estado del carrito
											$sql = " update carrito set ";
											$sql.= " estado=2 ";
											$sql.= " where id=:carrito_id ";
											$q = $pdo->prepare($sql);
											$q->execute([":carrito_id"=>$sCarrito]);

											$pdo->commit();
										} catch(PDOException $e) {
					            $pdo->rollBack();
											$resultado=[ "resultado"=> [ "codigo"=> 0, "mensaje" => "Se encontró un error en la ejecución",
												"mensaje_detalle"=> $e->getMessage()
											 ]];
								    }
									} else {
										$resultado=[ "resultado"=> [ "codigo"=> 1, "mensaje" => "No se encontró un carrito de compras activo",
										 	"mensaje_detalle"=> "" ]];
									}
								} else {
									$resultado=[ "resultado"=> [ "codigo"=> 1, "mensaje" => "No selecciono el Tipo de Pago",
										"mensaje_detalle"=> "" ]];
								}
							} else {
								$resultado=[ "resultado"=> [ "codigo"=> 1, "mensaje" => "No selecciono el Local de Recojo",
									"mensaje_detalle"=> "" ]];
							}
							break;
						case 'AP':	// Anular Pedido
							try {
	        			$pdo->beginTransaction();
								$sql = "update venta set estado=3 ";
								$sql.= " where id=:id and estado=1";
								$q = $pdo->prepare($sql);
								$q->execute([":id"=>$id]);
								$pdo->commit();
							} catch(PDOException $e) {
		            $pdo->rollBack();
								$resultado=[ "resultado"=> [ "codigo"=> 1, "mensaje" => "Se encontró un error en la ejecución",
									"mensaje_detalle"=> $e->getMessage()
								 ]];
					    }
							break;
						default:
							break;
					}
				} else {
					$resultado=[ "resultado"=> [ "codigo"=> 1, "mensaje" => "No ha iniciado sesión", "mensaje_detalle"=> "" ]];
				}
				break;
		}
		Database::disconnect();
	}
} else {
	$resultado = [ "resultado"=> [ "codigo"=> 1, "mensaje" => "No ha iniciado sesión", "mensaje_detalle"=> "" ]];
}
echo json_encode($resultado);
?>
