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
	// Query que seleciona chave e nome do produto
	$seleciona_produto = $conexao->query("SELECT cd_produto, nome, quantidade FROM compra_produto ORDER BY cd_produto");
	// Resulta em uma matriz
	$resultado_produto = $seleciona_produto->fetchAll();

	// Query que seleciona chave e nome do cliente
	$seleciona_fornecedor = $conexao->query("SELECT cd_fornecedor, nome FROM fornecedor ORDER BY cd_fornecedor");
	// Resulta em uma matriz
	$resultado_fornecedor = $seleciona_fornecedor->fetchAll();

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
	<title>Cadastrar Entrada</title>
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

				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Cadastrar entrada (Atalho = Alt + w)</h4>
								</div>
								<div class="card-body">
									<form method="POST" id="cad_ven" autocomplete="off" action="/web/crud/insert_entrada.php" onsubmit="exibirNome()">
										<fieldset>
											<div class="campos">
												<div class="row">
													<b>Dados da Entrada</b>
													<div class="col-md-6">
														<label>Escolha o funcionário *</label>
														<select name="cd_funcionario" class="cd_funcionario form-control" required="" title="Caixa de seleção para escolher o funcionário" accesskey="w">
															<option title="<?= $_SESSION['nome_usuario'] ?>" value="<?= $_SESSION['id_usuario'] ?>"><?= $_SESSION['nome_usuario'] ?></option>
														</select>
													</div>
													<div class="col-md-6">
														<label> Escolha o fornecedor *</label>
														<select name="cd_fornecedor" class="cd_fornecedor form-control" required="" title="Caixa de seleção para escolher o cliente">
															<option value="" title="Por padrão a opção é vazia, escolha abaixo o cliente"> Nenhum </option>
															<?php foreach ($resultado_fornecedor as $v3) : ?>
																<option title="<?= $v3['nome'] ?>" value="<?= $v3['cd_fornecedor'] ?>"><?= $v3['nome'] ?></option>
															<?php endforeach ?>
														</select>
													</div>
												</div>

												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>Descrição da Nota *</label>
															<input type="text" name="descricao" title="Campo para inserir a descrição do nota" id="descricao" class="form-control" placeholder="" required>
														</div>
													</div>
												</div>

												<div class="campo_0">
													<hr>
													<b>Lançar Item</b>
													<div class="produto">
														<div class="relative" style="position: relative;">
															<label>Escolha o produto *</label>
															<select onChange="buscaDados(this)" id="produto" class="form-control" title="Caixa de seleção para escolher o produto">
																<option value="" title="Por padrão a opção é vazia, escolha abaixo o produto desejado"> Nenhum </option>
																<?php foreach ($resultado_produto as $v1) : ?>
																	<option title="<?= $v1['nome'] ?>" value="<?= $v1['cd_produto'] ?>"><?= $v1['nome'] ?></option>
																<?php endforeach ?>
															</select>
														</div>

														<div class="row">
															<div class="col-md-3">
																<label> Quantidade</label>
																<input type="number" onchange="calcularValores()" id="produto_quantidade" class="form-control" title="Campo para inserir a quantidade de produtos para venda" min="0">
															</div>
															<div class="col-md-3">
																<label> Unitário</label>
																<input type="number" id="produto_valor" step="any"  onkeypress="$(this).mask('00000.00', {reverse:true})"  placeholder="0.00" pattern="\d+" class="valor_item form-control" title="Campo exibir valor do item">
															</div>
															<div class="col-md-3">
																<div class="form-group">
																	<label>Porcentagem da revenda *</label>
																	<select onclick="calcularValores()" class="form-control" name="porcentagem_revenda" id="porcentagem_revenda" title="Caixa de seleção para escolher a porcentagem de revenda do produto" class="form-control" placeholder="">

																		<option value="">Escolher</option>
																		<option value="5" title="Porcentagem de 5%">Porcentagem de 5%</option>
																		<option value="10" title="Porcentagem de 10%">Porcentagem de 10%</option>
																		<option value="15" title="Porcentagem de 15%">Porcentagem de 15%</option>
																		<option value="20" title="Porcentagem de 20%">Porcentagem de 20%</option>
																		<option value="25" title="Porcentagem de 25%">Porcentagem de 25%</option>
																		<option value="30" title="Porcentagem de 30%">Porcentagem de 30%</option>
																		<option value="35" title="Porcentagem de 35%">Porcentagem de 35%</option>
																		<option value="40" title="Porcentagem de 40%">Porcentagem de 40%</option>
																		<option value="45" title="Porcentagem de 45%">Porcentagem de 45%</option>
																		<option value="50" title="Porcentagem de 50%">Porcentagem de 50%</option>
																		<option value="55" title="Porcentagem de 55%">Porcentagem de 55%</option>
																		<option value="60" title="Porcentagem de 60%">Porcentagem de 60%</option>
																		<option value="65" title="Porcentagem de 65%">Porcentagem de 65%</option>
																		<option value="70" title="Porcentagem de 70%">Porcentagem de 70%</option>
																		<option value="75" title="Porcentagem de 75%">Porcentagem de 75%</option>
																		<option value="80" title="Porcentagem de 80%">Porcentagem de 80%</option>
																		<option value="85" title="Porcentagem de 85%">Porcentagem de 85%</option>
																		<option value="90" title="Porcentagem de 90%">Porcentagem de 90%</option>
																		<option value="95" title="Porcentagem de 95%">Porcentagem de 95%</option>
																		<option value="100" title="Porcentagem de 100%">Porcentagem de 100%</option>

																	</select>
																</div>
															</div>
															<div class="col-md-3">
																<label> Total</label>
																<input type="number" id="produto_total" step="any" readonly placeholder="0.00" class=" form-control" title="Campo para exibir valor total do item" min="0">
															</div>
														</div>
														<div class="col-md-3 d-flex align-items-center">
															<button class="d-inline-flex btn btn-success btn-round btn-fill pull-right" type="button" id="adicionar">Adicionar Produto</button>
														</div>
													</div>


												</div>
											</div>
											<hr>
											<b>Itens Registrados</b>
											<div class="">
												<table class="table table-responsive">
													<thead>
														<tr>

															<th scope="col">Produto</th>
															<th scope="col">Qtd * Vl. Uni</th>
															<th scope="col">Pct. Revenda</th>
															<th scope="col">Total</th>
															<th scope="col">Ações</th>
														</tr>
													</thead>
													<tbody id="table_itens">

														<!-- <tr>
															<th scope="row">1 <input type="hidden" class="cd_produto" name="cd_produto[]" value="15"></th>
															<td>Testexxx</td>
															<td>2x 5.50 <input type="hidden" name="quantidade[]" value="2"></td>
															<td>5.50</td>
															<td><a class="dropdown-item" style="border-radius: 20px;" href="/web/form_crud/form_delete_produto.php?id=' . $exibir_colunas['cd_produto'] . '">Excluir</a></td>
														</tr> -->
													</tbody>
												</table>
												<hr>
												<b>Total Nota: R$<span id="total_entrada">0,00</span></b>
											</div>
											<?php if (!empty($_GET['error'])) { ?>

												<div class="alert alert-danger" role="alert">
													<?= $_GET['error']; ?>
												</div>
											<?php } ?>
											<button class="btn btn-info btn-fill btn-round pull-right" name="Inserir" title="Botão para cadastrar a venda" onclick=""> Realizar Entrada </button>

										</fieldset>
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

	</div>

</body>
<?php include(dirname(__FILE__) . '/../layout/js.php'); ?>
<script type="text/javascript" src="/web/js/entrada/mascara_entrada.js"></script>
<script type="text/javascript" src="/web/js/entrada/requisicao_produto.js"></script>

<script type="text/javascript" src="/web/js/entrada/script_entrada.js"></script>

</html>