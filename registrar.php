<!DOCTYPE html>
<html lang="en">
	<head>
			<meta charset="utf-8">			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link href="css/bootstrap.min.css" rel="stylesheet">
			<script src="js/bootstrap.min.js"></script>
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
			<link href="css/ventas.css" rel="stylesheet">
	</head>

	<body class="d-flex flex-column h-100">
		<header>
			<h2>Registrar usuario</h2>
		</header>
		<main class="flex-shrink-0">
		  <div class="container">
				<form class="form " action="registro_guardar.php" method="post">
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
					<div class="form-actions">
						<button type="submit" class="btn btn-success">Guardar</button>
						<a class="btn btn-secondary" href="./">Salir</a>
					</div>
					<br />
				</form>
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
