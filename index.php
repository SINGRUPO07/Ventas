<?php
include_once("modelos/usuarioDto.php");
ob_start();
session_start();
$oUsuario = isset($_SESSION['_usuario']) ? new Usuario($_SESSION['_usuario']) : null;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
			<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
			<link href="css/ventas.css" rel="stylesheet">
			<script src="js/catalogo.js" type="text/javascript"></script>
	</head>

	<body class="d-flex flex-column h-100">
		<header>
			<div class="nav-inner">
				<nav class="navbar navbar-expand-lg">
					<a class="navbar-brand" href="./">
						<img src="img/logo.png" alt="Logo">
					</a>
					<button class="navbar-toggler mobile-menu-btn active" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
						<span class="toggler-icon"></span>
						<span class="toggler-icon"></span>
						<span class="toggler-icon"></span>
					</button>
					<div class="navbar-collapse sub-menu-bar collapse show" id="navbarSupportedContent" style="">
						<ul id="nav" class="navbar-nav ms-auto">
							<?php if(!empty($oUsuario)) { ?>
								<p><?php echo $oUsuario->usuario; ?></p><br />
							<?php } ?>

								<?php if(empty($oUsuario)) { ?>
									<li class="nav-item"><a href="login.php" aria-label="Toggle navigation">Iniciar sesi??n</a></li>
								<?php } else { ?>
									<?php if($oUsuario->tipo==1) { ?>
										<li class="nav-item"><a href="./admin" class="active" aria-label="Toggle navigation">Administraci??n</a></li>
									<?php } else { ?>
										<li class="nav-item">
											<a href="#" id="cambiar-localrecojo" class="active" aria-label="Toggle navigation" data-id="<?php echo isset($oUsuario->local_id) ? $oUsuario->local_id : "" ?>">
												<?php echo isset($oUsuario->clocal) ? $oUsuario->clocal : "Sel. Local recojo" ?>
											</a>
										</li>
										<li class="nav-item"><a href="./pedido" class="active" aria-label="Toggle navigation">Ver Pedidos</a></li>
										<li class="nav-item"><a href="./carrito" class="active" aria-label="Toggle navigation">Ver Carrito</a></li>
									<?php } ?>
									<li class="nav-item"><a href="logout.php" aria-label="Toggle navigation">Cerrar sesi??n</a></li>
								<?php } ?>
						</ul>
					</div>
					<div class="button">
						<a href="registrar.php" class="btn btn-info">Registrarme</a>
					</div>
				</nav>
			</div>
		</header>

		<main class="catalogo">
			<div class="contenedor-menu">
				<ul>
					<h5>Categor??as</h5>
					<ul id="lista-categorias">
					</ul>
				</ul>
			</div>
			<div class="contenedor-central">
			</div>
		</main>

		<footer class="footer mt-auto py-3 bg-light">
		  <div class="container">
		    <span class="text-muted">
					Todos los derechos reservados (r)
				</span>
		  </div>
		</footer>

		<div id="modal-detalle" class="modal" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
		</div>

	</body>
</html>
