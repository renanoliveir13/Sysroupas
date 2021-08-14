<?php
// Arquivo conexao.php
require_once '../conexao/conexao.php';
// Arquivo classe_usuario.php
require_once '../classe/classe_usuario.php';
// Inicio da sessao

$u = new Usuario();
$u->Verificar();

// Se a selecao for possivel de realizar
try {

	// Query que seleciona chave da tabela venda
	$seleciona_venda = $conexao->query("SELECT cd_venda FROM venda ORDER BY cd_venda");
	// Resulta em uma matriz
	$resultado_venda = $seleciona_venda->fetchAll();

	// Query que seleciona chave e nome do produto
	$seleciona_produto = $conexao->query("SELECT cd_produto, nome, quantidade FROM compra_produto ORDER BY cd_produto");
	// Resulta em uma matriz
	$resultado_produto = $seleciona_produto->fetchAll();

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
	<title>Cadastrar devolução</title>
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
									<h4 class="card-title">Cadastrar devolução (Atalho = Alt + w)</h4>
								</div>
								<div class="card-body">
									<form method="POST" id="cad_dev" autocomplete="off" action="/web/crud/insert_devolucao.php" onsubmit="exibirNome()">
										<fieldset>
											<div class="campos">
												<div class="row">
													<div class="col-md-4 pr-1">
														<div class="form-group">
															<label>Escolha a Venda *</label>
															<select onclick="buscaDados(this)" name="cd_venda" class="cd_venda form-control" required="" title="Caixa de seleção para escolher a venda" accesskey="w">
																<option value="" title="Opção vazia, escolha abaixo o cliente a ser atualizado"> Nenhum </option>
																<?php foreach ($resultado_venda as $valor) : ?>
																	<option title="<?= $valor['cd_venda'] ?>" value="<?= $valor['cd_venda'] ?>"><?= $valor['cd_venda'] ?></option>
																<?php endforeach ?>
															</select>
															<input type="hidden" name="cd_produto_venda[]" class="cd_produto_venda">
															<input type="hidden" name="cd_funcionario" class="cd_funcionario">

														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-4 pr-1">
														<div class="form-group">
															<label>Escolha o produto *</label>
															<select onclick="buscaDados2(this)" name="cd_produto[]" class="cd_produto form-control" required="" title="Caixa de seleção para escolher o produto">
																<option value="" title="Por padrão a opção é vazia, escolha abaixo o produto desejado"> Nenhum </option>
																<?php foreach ($resultado_produto as $v1) : ?>
																	<option title="<?= $v1['nome'] ?>" value="<?= $v1['cd_produto'] ?>"><?= $v1['nome'] ?></option>
																	<?php endforeach ?>-->
															</select>

														</div>
													</div>
												</div>
												<div class="col-md-4 px-1">
													<div class="form-group">
														<label>Valor do Item *</label>

														<input type="number" step="any" name="valor_item[]" placeholder="R$0.00" class="valor_item form-control" title="Campo para inserir o valor do produto" required="" readonly="readonly"> </p>
													</div>
												</div>

												<div class="col-md-4 px-1">
													<div class="form-group">
														<label>Quantidade *</label>

														<input type="number" name="quantidade[]" class="quantidade form-control" pattern="\d+" title="Campo para inserir a quantidade de produtos para venda" min="1" required="">
													</div>
												</div>

												<?php if (!empty($_GET['error'])) { ?>

													<div class="alert alert-danger" role="alert">
														<?= $_GET['error']; ?>
													</div>
												<?php } ?>
												<div class="row">
													<div class="col-md-4 pr-1">
														<div class="form-group">
															<label>Motivo da Devolução *</label>
															<select name="motivo_devolucao[]" class="cd_produto form-control" required="" title="Caixa de seleção para escolher o motivo da devolução">
																<option value="" title="Por padrão a opção é vazia, escolha abaixo o motivo da devolução">Nenhum selecionado</option>
																<option value="Produto danificado" title="Produto danificado">Produto danificado</option>
																<option value="Tamanho errado" title="Tamanho errado">Tamanho errado</option>
																<option value="Gênero errado de roupa" title="Gênero errado de roupa">Gênero errado de roupa</option>
																<option value="Arrependimento de compra" title="Arrependimento de compra">Arrependimento de compra</option>
															</select>

														</div>
													</div>
												</div>
											</div>
											<a class="btn btn-danger pull-left" href="/web/form_crud/form_select_devolucao.php">Voltar</a>
											<!-- <button type="button" id="adicionar">Adicionar devolução</button> -->
											<button type="submit" name="Inserir" class="btn btn-round btn-fill btn-info pull-right">Cadastrar</button>
										</fieldset>
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
<script type="text/javascript" src="/web/js/devolucao/mascara_devolucao.js"></script>
<script type="text/javascript" src="/web/js/devolucao/requisicao_venda.js"></script>
<script type="text/javascript" src="/web/js/script.js"></script>

</html>