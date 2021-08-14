<?php
session_start();
if (isset($_SESSION['id_usuario'])) {
	header("Location: inicio.php/#inicio");
	die;
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Sysroupas | Login </title>
	<link rel="stylesheet" href="/web/css/css.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/web/css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="stylesheet" href="/web/css/loginestilo.css">
	<script type="text/javascript" src="/web/js/senha_login/senha_login.js"></script>

</head>

<body>
	<div id="dashboard">
		<div class='dashboard'>
			<div class="dashboard-nav">
				<header><a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a><a <a </div>
			</div>
			<div class="container">
				<a class="links" id="paracadastro"></a>
				<a class="links" id="paralogin"></a>
				<div class="content">

					<form method="POST" autocomplete="off" action="/web/valida_login.php">
						<fieldset>
							<div id="login">
								<form method="post" action="">
									<h1><img src="https://i.pinimg.com/736x/63/e2/27/63e22787b31522fa6592b0326986cbb8.jpg">LOGIN</h1>
									<legend>
										<p align="center">SysRoupas</p>
									</legend>

									<p> Email: <input type="email" name="email" accesskey="w" title="Campo para digitar seu email" size=30 required maxlength="50" placeholder="ex. joao@gmail.com"> </p>

									<p> Senha:
										<input type="password" id="senha" name="senha" title="Campo para digitar sua senha" size="30" maxlength="32" required="" onclick="mostrarSenha()">
										<i class="fa fa-eye" id="text" aria-hidden="true" title="Ocultar senha"></i>
										<i class="fa fa-eye-slash" id="pass" aria-hidden="true" title="Exibir senha"></i>
									</p>
									<input type="submit" value="Entrar" name="Entrar" title="Entrar"></input>
						</fieldset>

					</form>
					<?php if (!empty($_GET['error'])) { ?>
						<div class="container">
							<div class="alert alert-danger" role="alert">
								<?= $_GET['error']; ?>
							</div>
						</div>
					<?php } ?>
				</div>
				<footer align="center">
					<p> Sistema desenvolvido na disciplina de <b>Laboratório e Programação Web II</b>. </p>
					<p> Por<a href="https://github.com/Iury189" target="_blank" title="Perfil do GitHub de Iury Fernandes">
							<b>
								<font color=black>Iury Fernandes</font>
							</b></a>, <a href="https://github.com/renanoliveir13" target="_blank" title="Perfil do GitHub de Renan Oliveira"> <b>
								<font color=black>Renan Oliveira</font>
							</b></a> e <a href="https://github.com/ThamiresAlmeida" target="_blank" title="Perfil do GitHub de Thamires Almeida"> <b>
								<font color=black>Thamires Almeida</font>
							</b></a>. </p>
				</footer>

</body>
</html>