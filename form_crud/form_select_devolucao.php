<?php
// Arquivo conexao.php
require_once '../conexao/conexao.php';
// Arquivo classe_usuario.php
require_once '../classe/classe_usuario.php';
$u = new Usuario();
$u->Verificar();

try {
	// Query que faz a selecao
	$selecao = "SELECT devolucao.cd_devolucao,venda.cd_venda, compra_produto.nome, produtos_venda.valor_item,
	produtos_devolucao.quantidade, produtos_venda.quantidade AS qtd_vendida, compra_produto.quantidade AS estoque, 
	produtos_devolucao.valor_devolucao, produtos_devolucao.motivo_devolucao, devolucao.data_devolucao FROM produtos_devolucao
	INNER JOIN produtos_venda ON (produtos_venda.cd_produto_venda = produtos_devolucao.cd_produto_venda)
	INNER JOIN venda ON (venda.cd_venda = produtos_venda.cd_venda)
	INNER JOIN compra_produto ON (compra_produto.cd_produto = produtos_venda.cd_produto)
	INNER JOIN devolucao ON (devolucao.cd_devolucao = produtos_devolucao.cd_devolucao)";
	// $seleciona_dados recebe $conexao que prepare a operacaoo para selecionar
	$seleciona_dados = $conexao->prepare($selecao);
	// Executa a operacao
	$seleciona_dados->execute();
	// Retorna uma matriz contendo todas as linhas do conjunto de resultados
	$linhas = $seleciona_dados->fetchAll(PDO::FETCH_ASSOC);
	// Se a selecao nao for possivel de realizar
} catch (PDOException $falha_selecao) {
	echo "A listagem de dados não foi feita".$falha_selecao->getMessage();
	die;
} catch (Exception $falha) {
	echo "Erro não característico do PDO".$falha->getMessage();
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
	<title>Listar devoluções</title>
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

						<div class="col-md-12">
							<div class="card card-plain-bg">
								<div class="card-header ">
									<center>
										<h4 class="card-title">Lista de devoluções (Atalho = Alt + w)</h4>
									</center>
									</br>
								</div>
								<fieldset class="mx-2 col-md-6" class="">
									 <input class="form-control" id="nome" accesskey="w" title="Campo para procurar determinado produto pelo nome" placeholder="Buscar produto devolvido"/>
								</fieldset>
								<div class="card-body table-full-width table-responsive">
									<table class="table table-hover" id="lista">
										<tr>
											<th title="ID"> ID </th>
											<th title="ID venda"> ID venda </th>
											<th title="Produto"> Produto </th>
											<th title="Valor item"> Valor item </th>
											<th title="Quantidade devolvida"> Qtd devolvida </th>
											<th title="Quantidade vendida"> Qtd vendida </th>
											<th title="Estoque"> Estoque </th>
											<th title="Valor da devolução"> Valor da devolução </th>
											<th title="Motivo da devolução"> Motivo da devolução </th>
											<th title="Data da devolução"> Data da devolução </th>
											<th title="Ações"> Ações </th>
										</tr>
										<?php 
										// Loop para exibir as linhas
										foreach ($linhas as $exibir_colunas) {
											echo '<tr>';
											echo '<td title="' . $exibir_colunas['cd_devolucao'] . '">' . $exibir_colunas['cd_devolucao'] . '</td>';
											echo '<td title="' . $exibir_colunas['cd_venda'] . '">' . $exibir_colunas['cd_venda'] . '</td>';
											echo '<td title="' . $exibir_colunas['nome'] . '">' . $exibir_colunas['nome'] . '</td>';
											echo '<td title="R$' . $exibir_colunas['valor_item'] . '">R$' . $exibir_colunas['valor_item'] . '</td>';
											echo '<td title="' . $exibir_colunas['quantidade'] . ' produto(s) devolvido(s)">' . $exibir_colunas['quantidade'] . '</td>';
											echo '<td title="' . $exibir_colunas['qtd_vendida'] . ' produto(s) vendido(s)">' . $exibir_colunas['qtd_vendida'] . '</td>';
											echo '<td title="' . $exibir_colunas['estoque'] . ' produto(s) em estoque">' . $exibir_colunas['estoque'] . '</td>';
											echo '<td title="R$' . $exibir_colunas['valor_devolucao'] . '">R$' . $exibir_colunas['valor_devolucao'] . '</td>';
											echo '<td title="' . $exibir_colunas['motivo_devolucao'] . '">' . $exibir_colunas['motivo_devolucao'] . '</td>';
											echo '<td title="' . date('d/m/Y H:i:s', strtotime($exibir_colunas['data_devolucao'])) . '">' .
												date('d/m/Y H:i:s', strtotime($exibir_colunas['data_devolucao'])) . '</td>';
											echo '
											<td class="actions">													
													<a class="btn btn-danger btn-xs"  style="border-radius: 20px;"href="/web/form_crud/form_delete_devolucao.php?id=' . $exibir_colunas['cd_devolucao'] . '" >Excluir</a>
												</td>';
											echo '</tr>';
											echo '</p>';
										}
										?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
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
<script type="text/javascript" src="/web/js/devolucao/select_devolucao.js"></script>

</html>