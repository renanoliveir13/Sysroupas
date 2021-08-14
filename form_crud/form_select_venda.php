	<?php
	// Arquivo conexao.php
	require_once '../conexao/conexao.php';
	// Arquivo classe_usuario.php
	require_once '../classe/classe_usuario.php';
	$u = new Usuario();
	$u->Verificar();

	try {
		// Query que faz a selecao
		$selecao = "SELECT venda.cd_venda, 
	funcionario.nome AS nome_funcionario, cliente.nome AS nome_cliente, 
	venda.tipo_pagamento, venda.data_venda,
	(SELECT count(*) FROM produtos_venda WHERE cd_venda = venda.cd_venda) as quantidade,
	COALESCE((SELECT sum(valor_venda) FROM produtos_venda WHERE cd_venda = venda.cd_venda),0) as valor_venda
	FROM venda
	INNER JOIN cliente ON (cliente.cd_cliente = venda.cd_cliente)
	INNER JOIN funcionario ON (funcionario.cd_funcionario = venda.cd_funcionario)
	ORDER BY venda.cd_venda DESC";
		// $seleciona_dados recebe $conexao que prepare a operacao para selecionar
		$seleciona_dados = $conexao->prepare($selecao);
		// Executa a operacao
		$seleciona_dados->execute();
		// Retorna uma matriz contendo todas as linhas do conjunto de resultados
		$linhas = $seleciona_dados->fetchAll(PDO::FETCH_ASSOC);
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
	<html lang="pt-br">

	<head>
		<meta charset="utf-8" />
		<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Listar vendas</title>
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
						<div class="col-md-12">
							<div class="card panel-default">
								<div class="panel-heading">

									<center>
										<h4 class="card-title">Listar vendas (Atalho = Alt + w)</h4>
									</center>
									</br>

									<fieldset class="mx-2 col-md-6" class="">
										<input class="form-control" id="nome" accesskey="w" title="Campo para procurar determinado produto vendido" placeholder="Buscar produto vendido" />
									</fieldset>
								</div>
								<div class="card-body bg-white">
									<table class="table table-" id="lista">
										<thead>
											<tr>
												<th title="ID"> ID </th>

												<th title="Funcionário"> Funcionário </th>
												<th title="Cliente"> Cliente </th>
												<th title="Quantidade vendida"> Qtd de Itens </th>
												<th title="Valor da venda"> Valor da venda </th>
												<th title="Pagamento"> Pagamento </th>
												<th title="Data da venda"> Data da venda </th>
												<th title="Ações"> Ações </th>
											</tr>
										</thead>
										<tbody>

											<?php
											// Loop para exibir as linhas
											foreach ($linhas as $exibir_colunas) {
												echo '<tr>';

												echo '<td class="accordion-toggle" data-toggle="collapse" data-target="#produtos_venda_' . $exibir_colunas['cd_venda'] . '" aria-expanded="false" aria-controls="produtos_venda_' . $exibir_colunas['cd_venda'] . '" title="' . $exibir_colunas['cd_venda'] . '">												
												<button class="btn btn-default btn-xs"><span class="fa fa-eye"></span> #' . $exibir_colunas['cd_venda'] . '</button>

												</td>';

												echo '<td title="' . $exibir_colunas['nome_funcionario'] . '">' . $exibir_colunas['nome_funcionario'] . '</td>';
												echo '<td title="' . $exibir_colunas['nome_cliente'] . '">' . $exibir_colunas['nome_cliente'] . '</td>';

												echo '<td title="' . $exibir_colunas['quantidade'] . ' produto(s) vendido(s)">' . $exibir_colunas['quantidade'] . '</td>';

												echo '<td title="R$' . $exibir_colunas['valor_venda'] . '">R$' . $exibir_colunas['valor_venda'] . '</td>';
												echo '<td title="' . $exibir_colunas['tipo_pagamento'] . '">' . $exibir_colunas['tipo_pagamento'] . '</td>';
												echo '<td title="' . date('d/m/y H:i:s', strtotime($exibir_colunas['data_venda'])) . '">' .
													date('d/m/y H:i', strtotime($exibir_colunas['data_venda'])) . '</td>';
												echo '
											<td class="actions">													
													<a class="btn btn-primary " style="border-radius: 20px;" <a href="/web/form_crud/form_update_venda.php?id=' . $exibir_colunas['cd_venda'] . '">Atualizar</a>
													<a class="btn btn-danger btn-xs"  style="border-radius: 20px;"href="/web/form_crud/form_delete_venda.php?id=' . $exibir_colunas['cd_venda'] . '" >Excluir</a>
												</td>';
												echo '</tr>';

												try {
													$seleciona_produtos = $conexao->prepare("
													SELECT produtos_venda.*, compra_produto.nome
													FROM produtos_venda
													LEFT JOIN compra_produto ON compra_produto.cd_produto = produtos_venda.cd_produto
													WHERE cd_venda = :cd_venda");
													// Executa a operacao
													$seleciona_produtos->execute([':cd_venda' => $exibir_colunas['cd_venda']]);
													// Retorna uma matriz contendo todas as linhas do conjunto de resultados
													$produtos = $seleciona_produtos->fetchAll(PDO::FETCH_ASSOC);
													// Se a selecao nao for possivel de realizar
												} catch (PDOException $falha_selecao) {
													echo "A listagem de dados não foi feita" . $falha_selecao->getMessage();
													die;
												} catch (Exception $falha) {
													echo "Erro não característico do PDO" . $falha->getMessage();
													die;
												}
												echo '<tr>
													<td colspan="12" class="hiddenRow">
														<div class="accordian-body collapse" id="produtos_venda_' . $exibir_colunas['cd_venda'] . '">
															<table class="table table-striped">
																<thead>
																	<tr class="info">
																		<th>Produto</th>
																		<th>Qtd * VL. Unitario</th>
																		<th>Valor Total</th>
																	</tr>
																</thead>
																<tbody>';
												if (empty($produtos)) {
													echo '<tr><td colspan="3" class="text-center">Não há produtos lançados. Clique em atualizar ou excluá esta nota. </td></tr>';
												}
												foreach ($produtos as $p) {
													echo '<tr>
																		<td>' . $p['nome'] . '</td>
																		<td>' . $p['quantidade'] . 'x R$' . number_format($p['valor_item'], 2, ',', '') . '</td>
																		<td>R$' . number_format($p['valor_venda'], 2, ',', '') . '</td>																		
																	</tr>';
												}
												echo '
																</tbody>
															</table>
														</div>
													</td>
												</tr>';
											}
											?>


										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
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
		<script type="text/javascript" src="/web/js/venda/select_venda.js"></script>

		<?php	include(dirname(__FILE__) . '/../layout/js.php'); ?>
		

	</body>

	</html>