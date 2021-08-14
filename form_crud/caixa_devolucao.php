<?php
// Arquivo conexao.php
require_once '../conexao/conexao.php';
// Arquivo classe_usuario.php
require_once '../classe/classe_usuario.php';
$u = new Usuario();
$u->Verificar();

try {

	$valor_detalhado = "SELECT devolucao.data_devolucao AS data_da_devolucao, produtos_venda.cd_produto, compra_produto.nome,
	produtos_devolucao.valor_item, SUM(produtos_devolucao.quantidade) AS qtd_devolvida,
	SUM(produtos_devolucao.valor_devolucao) AS devolucao_mes FROM devolucao
	INNER JOIN produtos_devolucao ON (produtos_devolucao.cd_devolucao = devolucao.cd_devolucao)
	INNER JOIN produtos_venda ON (produtos_venda.cd_produto_venda = produtos_devolucao.cd_produto_venda)
	INNER JOIN compra_produto ON (compra_produto.cd_produto = produtos_venda.cd_produto)
	ORDER BY data_da_devolucao, produtos_devolucao.cd_produto_venda";

	$seleciona_detalhes = $conexao->prepare($valor_detalhado);
	$seleciona_detalhes->execute();
	$linhas_detalhes = $seleciona_detalhes->fetchAll(PDO::FETCH_ASSOC);


	$valor_total = "SELECT YEAR(devolucao.data_devolucao) AS ano, SUM(produtos_devolucao.valor_devolucao) AS devolucao_total FROM devolucao
	INNER JOIN produtos_devolucao ON (produtos_devolucao.cd_devolucao = devolucao.cd_devolucao)
	ORDER BY YEAR(devolucao.data_devolucao)";

	$seleciona_total = $conexao->prepare($valor_total);
	$seleciona_total->execute();
	$linhas_total = $seleciona_total->fetchAll(PDO::FETCH_ASSOC);
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
<html lang="pt-br">

<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Fluxo de devoluções</title>
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

				<!-- fim Navbar -->
				<div class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<div class="card card-plain table-plain-bg">
									<div class="card-header ">
										<center>
											<h4 class="card-title">Fluxo de devoluções</h4>
											</br>
											<ul class="nav nav-pills mb-3 nav-fill" id="pills-tab" role="tablist">
												<li class="nav-item">
													<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Movimentação Anual</a>
													</li>
												<li class="nav-item">
													<a class="nav-link " id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Movimentação Detalhada</a>
												</li>
											</ul>
										</center>
									</div>
									</br>
								</div>
							</div>
						</div>
					</div>


					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

							<table class="table table-hover">
								<thead>
									<tr>
										<th scope="col">Ano</th>
										<th scope="col">Valor total de devoluções</th>

									</tr>
								</thead>
								<tbody>

									<?php
									foreach ($linhas_total as $exibir_colunas) {
										echo '<tr>';
										echo '<th scope="row" title="' . $exibir_colunas['ano'] . '">' . $exibir_colunas['ano'] . '</td>';
										echo '<td title="R$' . $exibir_colunas['devolucao_total'] . '">R$' . $exibir_colunas['devolucao_total'] . '</td>';
										echo '</tr>';
									}
									?>
								</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
							<table class="table">
								<thead>
									<tr>
										<th scope="col" title="Data"> Data da venda </th>
										<th scope="col" title="Produto"> Produto </th>
										<th scope="col" title="Valor item"> Valor item </th>
										<th scope="col" title="Quantidade devolvida"> Quantidade devolvida </th>
										<th scope="col" title="Total"> Total </th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($linhas_detalhes as $exibir_colunas) {
										echo '<tr>';
										echo '<th scope="row" title="' . date('d/m/Y H:i:s', strtotime($exibir_colunas['data_da_devolucao'])) . '">' .
											date('d/m/Y H:i:s', strtotime($exibir_colunas['data_da_devolucao'])) . '</th>';
										echo '<td title="' . $exibir_colunas['nome'] . '">' . $exibir_colunas['nome'] . '</td>';
										echo '<td title="R$' . $exibir_colunas['valor_item'] . '">R$' . $exibir_colunas['valor_item'] . '</td>';
										echo '<td title="' . $exibir_colunas['qtd_devolvida'] . ' produto(s) vendido(s)">' . $exibir_colunas['qtd_devolvida'] . '</td>';
										echo '<td title="R$' . $exibir_colunas['devolucao_mes'] . '">R$' . $exibir_colunas['devolucao_mes'] . '</td>';
										echo '</tr>';
									}
									?>
									</tbody>
							</table>
						</div>
					</div>
				</div>
				</br>
				</br>
				</br>
				</br>
				</br>
				</br>
			
			</div>
			<!-- Modal -->
			<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="modalLabel">Excluir Item</h4>
						</div>
						<div class="modal-body">
							Deseja realmente excluir este item?
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary">Sim</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
						</div>
					</div>
				</div>
			</div>
			<footer class="footer" style="background-color: #DCDCDC">
				<div class="container-fluid">
					<nav>

						<p class="copyright text-center">
							© WEB 2
						</p>
					</nav>
				</div>
			</footer>
		</div>
	</div>
</body>
<?php include(dirname(__FILE__) . '/../layout/js.php'); ?>

</html>