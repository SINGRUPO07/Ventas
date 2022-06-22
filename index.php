<?php
session_start();
include_once("modelos/usuarioDto.php");
$oUsuario = $_SESSION['_usuario'];
//var_dump($oUsuario);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
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
							<!-- <li class="nav-item">
								<a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#submenu-1-1" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">Pages</a>
								<ul class="sub-menu collapse" id="submenu-1-1" style="">
									<li class="nav-item"><a href="domain.html">Domain</a></li>
									<li class="nav-item"><a href="about-us.html">About Us</a></li>
									<li class="nav-item"><a href="pricing.html">Pricing</a></li>
									<li class="nav-item"><a href="faq.html">Faq</a></li>
									<li class="nav-item"><a href="signin.html">Sign In</a></li>
									<li class="nav-item"><a href="signup.html">Sign Up</a></li>
									<li class="nav-item"><a href="reset-password.html">Reset Password</a></li>
									<li class="nav-item"><a href="mail-success.html">Mail Success</a></li>
									<li class="nav-item"><a href="404.html">404 Error</a></li>
								</ul>
							</li>
							<li class="nav-item">
								<a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#submenu-1-2" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">Hosting</a>
								<ul class="sub-menu collapse" id="submenu-1-2">
									<li class="nav-item"><a href="shared-hosting.html">Shared Hosting</a></li>
									<li class="nav-item"><a href="dedicated-hosting.html">Dedicated Servers</a></li>
									<li class="nav-item"><a href="vps-hosting.html">VPS Servers</a></li>
									<li class="nav-item"><a href="reseller-hosting.html">Reseller Hosting</a></li>
								</ul>
							</li>
							<li class="nav-item">
								<a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#submenu-1-3" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">Blog</a>
								<ul class="sub-menu collapse" id="submenu-1-3">
									<li class="nav-item"><a href="blog-grid.html">Blog Grid</a></li>
									<li class="nav-item"><a href="blog-single.html">Blog Single</a></li>
								</ul>
							</li> -->
							<li class="nav-item">
								<a href="login.php" aria-label="Toggle navigation">Iniciar sesión</a>
							</li>
						</ul>
					</div>
					<div class="button">
						<a href="registrar.php" class="btn">Registrarme</a>
					</div>
				</nav>
			</div>
		</header>

		<main class="flex-shrink-0">
		  <div class="container-fluid">
				<div class="row">
					<div class="col-3">
						<ul>
							<a href="#">Categorías</a>
							<ul>
								<li>a</li>
								<li>b</li>
								<li>c</li>
								<li>d</li>
							</ul>
						</ul>
					</div>
					<div class="col-9">
						<div class="row">
							<div class="card col-3">
							  <div class="card-body">
							    <h5 class="card-title">Card title</h5>
							    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
							    <a href="#" class="btn btn-primary">Go somewhere</a>
							  </div>
							</div>
							<div class="card col-3">
							  <div class="card-body">
							    <h5 class="card-title">Card title</h5>
							    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
							    <a href="#" class="btn btn-primary">Go somewhere</a>
							  </div>
							</div>
							<div class="card col-3">
							  <div class="card-body">
							    <h5 class="card-title">Card title</h5>
							    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
							    <a href="#" class="btn btn-primary">Go somewhere</a>
							  </div>
							</div>
							<div class="card col-3">
							  <div class="card-body">
							    <h5 class="card-title">Card title</h5>
							    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
							    <a href="#" class="btn btn-primary">Go somewhere</a>
							  </div>
							</div>
							<div class="card col-3">
							  <div class="card-body">
							    <h5 class="card-title">Card title</h5>
							    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
							    <a href="#" class="btn btn-primary">Go somewhere</a>
							  </div>
							</div>
						</div>
					</div>
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
