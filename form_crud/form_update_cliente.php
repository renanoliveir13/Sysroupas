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
	header('Location: /web/form_crud/form_select_cliente.php');
}

try {
	// Query que seleciona os dados do registro
	$query = $conexao->prepare("SELECT * FROM cliente WHERE cd_cliente = :id");
	$query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
	// Executa a operacao
	$query->execute();
	// Resulta em uma matriz
	$dados = $query->fetch(PDO::FETCH_ASSOC);

	//Verifica se houve retorno na query, se não, o cadastro não é válido e retorna o usuário para tela de listagem
	if (empty($dados)) {
		header('Location: /web/form_crud/form_select_cliente.php');
	}
	// Se a selecao nao for possivel de realizar
} catch (PDOException $falha_selecao) {
	echo "A listagem de dados não foi feita" . $falha_selecao->getMessage();
	die;
} catch (Exception $falha) {
	echo "Erro não característico do PDO" . $falha->getMessage();
	die;
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
	<title>Atualizar cliente</title>
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
									<h4 class="card-title">Atualizar cliente (Atalho = Alt + w)</h4>
								</div>
								<div class="card-body">
									<form method="POST" id="atu_forn" autocomplete="off" action="/web/crud/update_cliente.php" onsubmit="exibirNome()">
										<div class="col-md-4 pl-1">
											<div class="form-group">
												<label>ID Cliente *</label>
												<input id="cd_cliente" readonly name="cd_cliente" type="number" value="<?= $dados['cd_cliente']; ?>" class="form-control" accesskey="w" title="Campo que mostra o registro do cliente">
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 pr-1">
												<div class="form-group">
													<label>Nome *</label>
													<input id="nome" name="nome" required type="text" class="form-control" value="<?= $dados['nome']; ?>" placeholder="Ex: José da Silva" title="Campo para atualizar o nome do cliente">
												</div>
											</div>
											<div class="col-md-6 pl-1">
												<div class="form-group">
													<label for="exampleInputEmail1">CPF *</label>
													<input id="cpf" name="cpf" required type="text" class="form-control" value="<?= $dados['cpf']; ?>" placeholder="Ex: 123.123.123-30" title="Campo para atualizar o CPF do cliente">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 pr-1">
												<div class="form-group">
													<label for="phone">Telefone *</label>
													<input type="text" class="form-control" id="telefone" onkeypress="$(this).mask('(00) 0000-0000')" name="telefone" value="<?= $dados['telefone']; ?>" placeholder="Ex:(99) 9999-9999" pattern="(\([0-9]{2}\))\s([0-9]{0-9})?([0-9]{4})-([0-9]{4})" title="Campo para atualizar o telefone do cliente" required="required" />
												</div>
											</div>
											<div class="col-md-6 pl-1">
												<div class="form-group">
													<label for="exampleInputEmail1">Email *</label>
													<input id="email" name="email" title="Campo para atualizar o email do cliente"required type="email" class="form-control" value="<?= $dados['email']; ?>" placeholder="Ex: jose@gmail.com">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 pr-1">
												<div class="form-group">
													<label>Cidade *</label>
													<input type="text" id="cidade" name="cidade" value="<?= $dados['cidade']; ?>" class="form-control" placeholder="" required title="Campo para atualizar a cidade do cliente">
												</div>
											</div>
											<div class="col-md-6 pl-1">
												<div class="form-group">
													<label>Bairro *</label>
													<input type="text" id="bairro" name="bairro" class="form-control" value="<?= $dados['bairro']; ?>" required title="Campo para atualizar o bairro do cliente">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-4 pr-1">
												<div class="form-group">
													<label>Rua *</label>
													<input type="text" id="rua" name="rua" class="form-control" value="<?= $dados['rua']; ?>" required title="Campo para atualizar o nome da rua do cliente">
												</div>
											</div>
											<div class="col-md-4 px-1">
												<div class="form-group">
													<label>Número *</label>
													<input type="text" id="numero" name="numero" class="form-control" value="<?= $dados['numero']; ?>" required title="Campo para atualizar o número da casa do cliente">
												</div>
											</div>
										</div>
										<?php if (!empty($_GET['error'])) { ?>

											<div class="alert alert-danger" role="alert">
												<?= $_GET['error']; ?>
											</div>
										<?php } ?>
										<a class="btn btn-danger pull-left" href="/web/form_crud/form_select_cliente.php">Voltar</a>
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