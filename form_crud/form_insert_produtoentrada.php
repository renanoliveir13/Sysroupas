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
	header('Location: /web/form_crud/form_select_produto.php');
}

// Se a selecao for possivel de realizar
try {

	//Query que seleciona chave e nome do fornecedor
	$seleciona = $conexao->prepare("SELECT * FROM compra_produto WHERE cd_produto = ?");
	$seleciona->execute([$_GET['id']]);
	// Resulta em uma matriz
	$resultado = $seleciona->fetch();

	// Se a selecao nao for possivel de realizar
} catch (PDOException $falha_selecao) {
	$error = "A listagem de dados não foi feita" . $falha_selecao->getMessage();
} catch (Exception $falha) {
	$error = "Erro não característico do PDO" . $falha->getMessage();
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
	<title>Cadastrar entrada do produto</title>
	<link rel="stylesheet" href="/web/css/estiloBotao.css" />
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
				<form method="POST" id="cad_forn" autocomplete="off" action="/web/crud/insert_produto.php">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-8">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Entrada produto (Atalho = Alt + w)</h4>
									</div>
									<div class="card-body">
										<form>
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label>ID Produto *</label>
														<input type="text" readonly name="cd_produto" value="<?= $_GET['id']; ?>" title="Campo que mostra o ID do produto" class="form-control" placeholder="" accesskey="w" required>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Quantidade Atual *</label>
														<input type="text" readonly value="<?= $resultado['quantidade']; ?>" title="Campo que mostra a quantidade atual do produto" class="form-control" placeholder="" required>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label>Quantidade *</label>
														<input type="number" name="quantidade" class="form-control" placeholder="" required title="Campo para inserir a quantidade do produto">
													</div>
												</div>
											</div>

											<?php if (!empty($_GET['error'])) { ?>

												<div class="alert alert-danger" role="alert">
													<?= $_GET['error']; ?>
												</div>
											<?php } ?>
											<a class="btn btn-danger pull-left" href="/web/form_crud/form_select_produto.php">Voltar</a>
											<button type="submit" name="Entrada" title="Botão para cadastrar a quantidade" class="btn btn-round btn-fill btn-info pull-right">Cadastrar</button>
											<div class="clearfix"></div>
										</form>
									</div>
								</div>
							</div>

						</div>
					</div>
				</form>

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