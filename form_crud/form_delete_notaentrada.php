<?php
// Arquivo conexao.php
require_once '../conexao/conexao.php';
// Arquivo classe_usuario.php
require_once '../classe/classe_usuario.php';
// Inicio da sessao

$u = new Usuario();
$u->Verificar();

//Retorna para a listagem caso o parametro 'id' não existir ou estiver vazio
if (empty($_GET['id'])) {
	header('Location: /web/form_crud/form_select_funcionario.php');
}

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
	<title>Excluir entrada</title>
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
									<h4 class="card-title">Excluir entrada (Atalho = Alt + w)</h4>
									<h5 class="text mt-2">Deseja excluir este registro?</h5>
									<h5 class="text mt-2">A entrada será excluida, assim como os itens registrados.</h5>
								</div>
								<div class="card-body">
									<form method="POST" action="/web/crud/delete_notaentrada.php">

										<div class="row">
											<div class="col-md-12 pr-1">
												<div class="form-group">
													<label>ID entrada *</label>													
													<input type="number" readonly name="cd_entrada" value="<?= $_GET['id']; ?>" class="form-control" accesskey="w" title="Campo que mostra o registro da entrada">
												</div>
											</div>
										</div>
										<?php if (!empty($_GET['error'])) { ?>

											<div class="alert alert-danger" role="alert">
												<?= $_GET['error']; ?>
											</div>
										<?php } ?>
										<a type="button" class="btn btn-danger pull-left" href="/web/form_crud/form_select_notaentrada.php">Voltar</a>
										<button type="submit" name="Deletar" class="btn btn-round btn-fill btn-info pull-right">Excluir</button>
										<div class="clearfix"></div>
									</form>
								</div>
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

</html>