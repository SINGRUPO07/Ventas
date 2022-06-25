<?php
include_once("../modelos/usuarioDto.php");
if(isset($_COOKIE["PHPSESSID"])) session_id($_COOKIE["PHPSESSID"]);
ob_start();
session_start();
include_once("../modelos/productoDto.php");
require_once("../database.php");
$oUsuario = isset($_SESSION['_usuario']) ? new Usuario($_SESSION['_usuario']) : null;
header('Content-Type: application/json; charset=utf-8');
//echo json_encode($_SERVER["HTTP_COOKIE"]);
//echo json_encode($_COOKIE["PHPSESSID"]);
// echo json_encode($oUsuario);
// exit();
if(!empty($oUsuario)) {
	// var_dump($oUsuario);
	// exit();
}
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$pdo = Database::connect();
		$metodo = $_SERVER["REQUEST_METHOD"];
		switch($metodo) {
			case 'GET':
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sWhere = "";
				$ids = isset($_GET["ids"]) && !empty($_GET["ids"]) ? explode("-", $_GET["ids"]) : [];
				//var_dump($ids);
				if(!empty($ids)) {
					$in  = substr(str_repeat('?,', count($ids)),0,-1);
					$sWhere = "Where categoria_id in ($in)";
				}
				$sql = "select pr.*, ".(!empty($oUsuario) ? "1" : "0")." valido, case when pr.stock>0 then 1 else 0 end tienestock from";
				$sql.= " ( select p.id, p.nombre, p.descripcion, p.descripcionlarga, p.precio, p.categoria_id, ";
				$sql.= " coalesce(( select sum(stock) stock from producto_local pl where p.id=pl.producto_id ), 0) stock ";
				$sql.= " from producto p) pr " . $sWhere;
				$sql.= " order by tienestock desc ";
				// var_dump($sql);
				$q = $pdo->prepare($sql);
				if(!empty($ids)) {
					$q->execute($ids);
				} else {
					$q->execute();
				}
				$lProducto = $q->fetchAll(PDO::FETCH_CLASS, "Producto");
				echo json_encode($lProducto);
				break;
			/*case "POST":
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
				break;*/
		}
		Database::disconnect();

	}
// } else {
// 	echo json_encode([ error=> [ codigo=> 1, mensaje => "No cuenta con acceso al contenido" ]]);
// }
?>
