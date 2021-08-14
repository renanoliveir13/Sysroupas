<?php
// Arquivo conexao.php
require_once '../conexao/conexao.php';
// Arquivo classe_usuario.php
require_once '../classe/classe_usuario.php';
// Inicio da sessao

$u = new Usuario();
$u->Verificar();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Alterar senha</title>
	 <link rel="stylesheet" href="/web/css/estiloBotao.css"/>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<?php include(dirname(__FILE__) . '/../layout/css.php'); ?>

</head>

<body>
	<div class="wrapper">
		<?php include(dirname(__FILE__) . '/../layout/menu.php'); ?>
		<div class="main-panel">
			<!-- Navbar -->
			<nav class="navbar navbar-expand-lg " color-on-scroll="500" style="background-color: #DCDCDC">
				<div class="container-fluid">

					<div class="collapse navbar-collapse justify-content-end" id="navigation">
						<ul class="nav navbar-nav mr-auto">
						</ul>
						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link" href="#">
									<span class="no-icon">SysRoupas</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<!-- fim Navbar -->
			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-8">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Alterar senha (Atalho = Alt + w)</h4>
								</div>
								<div class="card-body">
									<form method="POST" autocomplete="off" id="alt_senha" action="/web/crud/update_senha.php" onsubmit="exibirNome()">
										<div class="row">
											<div class="col-md-3 pr-1">
												<div class="form-group">
													<label>ID funcionário *</label>
													<input name="cd_funcionario" id="cd_funcionario" readonly value="<?= $_SESSION['id_usuario']; ?>" type="text" class="form-control" accesskey="w" title="Campo que mostra o registro do funcionário">
												</div>
											</div>

										</div>
										<div class="row">
											<div class="col-md-3 pr-1">
												<div class="form-group">
													<label>Senha atual *</label>
													<input class="form-control" type="password" name="senha" id="senha" title="Campo para inserir sua senha atual" size="30" maxlength="32" required="" onclick="mostrarSenha()">
												</div>
											</div>

										</div>


										<div class="row">
											<div class="col-md-3 pr-1">
												<div class="form-group">
													<label>Nova senha *</label>
													<input class="form-control" type="password" name="senha_nova" id="senha_nova" title="Campo para inserir sua nova senha" size="30" maxlength="32" required="" onclick="mostrarNovaSenha()">
												</div>
											</div>

										</div>
										<div class="row">
											<div class="col-md-3 pr-1">
												<div class="form-group">
													<label>Redigite a nova senha *</label>
													<input class="form-control" type="password" name="confirmar_senha_nova" id="confirmar_senha_nova" title="Campo para inserir novamente a sua nova senha" size="30" maxlength="32" required="" onclick="mostrarConfirmarSenha()">
												</div>
											</div>

										</div>
										<?php if (!empty($_GET['error'])) { ?>

											<div class="alert alert-danger" role="alert">
												<?= $_GET['error']; ?>
											</div>
										<?php } ?>

										<button type="submit" name="Atualizar" class="btn btn-round btn-fill btn-info pull-right">Atualizar</button>

										<div class="clearfix"></div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>

				
			</div>
			<footer class="footer" style="background-color: #DCDCDC">
				<div class="container-fluid">
					<nav>

						<p class="copyright text-center">
							©WEB 2
						</p>
					</nav>
				</div>
			</footer>
		</div>
		</form>
		
	</div>

</body>
<?php include(dirname(__FILE__) . '/../layout/js.php'); ?>
<script type="text/javascript" src="/web/js/cliente/mascara_cliente.js"></script>
<script type="text/javascript" src="/web/js/cliente/requisicao_cliente.js"></script>
<script type="text/javascript" src="/web/js/cliente/senha_cliente.js"></script>
<script type="text/javascript" src="/web/js/alerta/alerta_update.js" charset="UTF-8"></script>

</html>