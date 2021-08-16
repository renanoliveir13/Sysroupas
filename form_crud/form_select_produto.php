<?php
// Arquivo conexao.php
require_once '../conexao/conexao.php';
// Arquivo classe_usuario.php
require_once '../classe/classe_usuario.php';
$u = new Usuario();
$u->Verificar();


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
	<title>Listar produtos</title>
	<link rel="stylesheet" href="/web/css/estiloBotao.css" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<?php include(dirname(__FILE__) . '/../layout/css.php'); ?>


</head>

<body>

	<?php
	// Se a selecao for possivel de realizar
	try {
		$selecao = "SELECT compra_produto.cd_produto, compra_produto.nome, compra_produto.tipo, 
			compra_produto.marca, compra_produto.codigo_barra, compra_produto.cor,
			compra_produto.tamanho, compra_produto.genero, compra_produto.quantidade, 
			compra_produto.valor_compra, compra_produto.porcentagem_revenda, compra_produto.valor_revenda, 
			DATE_FORMAT(compra_produto.data_compra ,'%d/%m/%Y %H:%i') as data_compra
			FROM compra_produto";
		// $seleciona_dados recebe $conexao que prepare a operacao para selecionar
		$seleciona_dados = $conexao->prepare($selecao);
		// Executa a operacao
		$seleciona_dados->execute();
		// Retorna uma matriz contendo todas as linhas do conjunto de resultados
		$linhas = $seleciona_dados->fetchAll(PDO::FETCH_ASSOC);
		// Se a selecao nao for possivel de realizar
	} catch (PDOException $falha_selecao) {
		$error = "A listagem de dados não foi feita" . $falha_selecao->getMessage();
	} catch (Exception $falha) {
		$error = "Erro não característico do PDO" . $falha->getMessage();
	}
	?>
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
							<div class="card card-plain-bg">
								<div class="card-header ">
									<center>
										<h4 class="card-title">Lista de produtos (Atalho = Alt + w)</h4>
									</center>
									</br>
								</div>
								<fieldset class="mx-2 col-md-6" class="">
									<input class="form-control" id="nome" accesskey="w" title="Campo para procurar determinado produto pelo nome" placeholder="Buscar produto" />
								</fieldset>
								<div class="card-body table-full-width table-responsive">
									<table class="table table-hover" id="lista">
										<tr>
											
											<th>Descrição</th>
											<th>Tipo</th>
											<th>Marca</th>
											<th>Código de barra</th>
											<th>Cor</th>
											<th>Tamanho</th>
											<th>Gênero</th>
											<th>Quantidade</th>
											<th>Valor da compra</th>
											<th>Porcentagem de revenda</th>
											<th>Valor Revenda</th>
											<th>Data</th>
											<th>AÇÕES</th>
										</tr>
										<?php
										// Loop para exibir as linhas
										if (!empty($linhas))
											foreach ($linhas as $exibir_colunas) {
												echo '<tr>';
												
												echo '<td title="' . $exibir_colunas['nome'] . '">' . $exibir_colunas['nome'] . '</td>';
												echo '<td title="' . $exibir_colunas['tipo'] . '">' . $exibir_colunas['tipo'] . '</td>';
												echo '<td title="' . $exibir_colunas['marca'] . '">' . $exibir_colunas['marca'] . '</td>';
												echo '<td title="' . $exibir_colunas['codigo_barra'] . '">' . $exibir_colunas['codigo_barra'] . '</td>';
												echo '<td title="' . $exibir_colunas['cor'] . '">' . $exibir_colunas['cor'] . '</td>';
												echo '<td title="' . $exibir_colunas['tamanho'] . '">' . $exibir_colunas['tamanho'] . '</td>';
												echo '<td title="' . $exibir_colunas['genero'] . '">' . $exibir_colunas['genero'] . '</td>';
												echo '<td title="' . $exibir_colunas['quantidade'] . ' produto(s)">' . $exibir_colunas['quantidade'] . '</td>';
												echo '<td title="R$' . $exibir_colunas['valor_compra'] . '">R$' . $exibir_colunas['valor_compra'] . '</td>';
												echo '<td title="' . $exibir_colunas['porcentagem_revenda'] . '%">' . $exibir_colunas['porcentagem_revenda'] . '%</td>';
												echo '<td title="R$' . $exibir_colunas['valor_revenda'] . '">R$' . $exibir_colunas['valor_revenda'] . '</td>';
												echo '<td title="' . $exibir_colunas['data_compra'] . '">' . $exibir_colunas['data_compra'] . '</td>';
												echo '
												<td class="actions" title="Ações">
												<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												 	Ações
											  	</button>
												<div class="dropdown-menu">													
													<a class="dropdown-item " style="border-radius: 20px;" <a href="/web/form_crud/form_update_produto.php?id=' . $exibir_colunas['cd_produto'] . '" title="Atualizar">Atualizar</a>
													<a class="dropdown-item" style="border-radius: 20px;" <a href="/web/form_crud/form_insert_produtoentrada.php?id=' . $exibir_colunas['cd_produto'] . '" title="Entrada">Entrada</a>
													<a class="dropdown-item" style="border-radius: 20px;" <a href="/web/form_crud/form_select_produtohistorico.php?id=' . $exibir_colunas['cd_produto'] . '" title="Histórico">Histórico</a>
													<a class="dropdown-item"  style="border-radius: 20px;"href="/web/form_crud/form_delete_produto.php?id=' . $exibir_colunas['cd_produto'] . '" title="Excluir">Excluir</a>
													</div>
												</td>';
												echo '</tr>';
												echo '</p>';
											}
										?>
									</table>
									<?php if (!empty($error)) { ?>

										<div class="mx-5 alert alert-danger" role="alert">
											<?= $error; ?>
										</div>
									<?php } ?>
								</div>
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
	<script type="text/javascript" src="/web/js/produto/select_produto.js"></script>

</body>
<?php include(dirname(__FILE__) . '/../layout/js.php'); ?>

</html>