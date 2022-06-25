<!DOCTYPE html>
<html lang="en">
	<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
			<link href="css/ventas.css" rel="stylesheet">
	</head>

	<body>
		<header>
			<div class="nav-inner">
				<nav class="navbar navbar-expand-lg">
					<a class="navbar-brand" href="index.html">
						<img src="img/logo.png" alt="Logo">
					</a>
					<button class="navbar-toggler mobile-menu-btn active" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
						<span class="toggler-icon"></span>
						<span class="toggler-icon"></span>
						<span class="toggler-icon"></span>
					</button>
					<div class="navbar-collapse sub-menu-bar collapse show" id="navbarSupportedContent" style="">
						<ul id="nav" class="navbar-nav ms-auto">
							<li class="nav-item">
								<a href="./" class="active" aria-label="Toggle navigation">Inicio</a>
							</li>
						</ul>
					</div>
					<div class="button">
						<a href="registrar.php" class="btn btn-info">Registrarme</a>
					</div>
				</nav>
			</div>
		</header>

		<main class="flex-shrink-0">
		  <div class="container-lg">
				<div class="row justify-content-center">
					<div class="col-md-6 col-sm-8">
						<form class="form form-primary" action="login_guardar.php" method="post">
							<div class="control-group <?php echo !empty($usuarioError)?'error':'';?>">
								<label class="control-label">Usuario:</label>
							</div>
							<div class="controls">
								<input type="text" name="usuario" class="form-control" placeholder="Nombre de usuario" />
								<?php if (!empty($usuarioError)) { ?>
									<span class="help-inline"><?php echo $usuarioError;?></span>
								<?php } ?>
							</div>
							<br />
							<div class="control-group <?php echo !empty($contrasenaError)?'error':'';?>">
									<label class="control-label">Contraseña:</label>
							</div>
							<div class="controls">
								<input type="password" name="contrasena" class="form-control" placeholder="Contraseña" />
								<?php if (!empty($contrasenaError)) { ?>
									<span class="help-inline"><?php echo $contrasenaError;?></span>
								<?php } ?>
							</div>
							<br />
							<div class="form-actions d-grid">
								<button type="submit" class="btn btn-outline-success">Iniciar sesión</button>
							</div>
							<br />
						</form>
					</div>
		  </div>
		</main>

		<footer class="footer mt-auto py-3 bg-light">
		  <div class="container">
		    <span class="text-muted">
					Todos los derechos reservados (r)
				</span>
		  </div>
		</footer>
	</body>
</html>
