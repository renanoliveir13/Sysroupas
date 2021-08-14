<?php
// Arquivo conexao.php
require_once '../conexao/conexao.php';
// Arquivo classe_usuario.php
require_once '../classe/classe_usuario.php';
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
<html lang="pt-br">

<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Listar Histórico Produto</title>
	<link rel="stylesheet" href="/web/css/estiloBotao.css" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<?php include(dirname(__FILE__) . '/../layout/css.php'); ?>


</head>

<body>

	<?php
	// Se a selecao for possivel de realizar
	try {

		$cd_produto = $_GET['id'];

		$selecao = "SELECT t.quantidade, t.data, t.tipo 
		FROM(
			SELECT quantidade, data_entrada as data, 'Entrada' as tipo
			FROM produtos_entrada
			WHERE cd_produto = :id
			UNION ALL
			SELECT quantidade, data_venda as data, CONCAT('Venda #',cd_venda) as tipo
			FROM produtos_venda
			WHERE cd_produto = :id
			UNION ALL
			SELECT quantidade, data_devolucao as data, CONCAT('Devolução #',cd_devolucao) as tipo
			FROM produtos_devolucao
			WHERE cd_produto = :id
		)t
		ORDER BY t.data DESC";
		// $seleciona_dados recebe $conexao que prepare a operacao para selecionar
		$seleciona_dados = $conexao->prepare($selecao);
		// Executa a operacao		
		$seleciona_dados->execute([':id'=>$cd_produto]);
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
										<h4 class="card-title"><b><?= $resultado['nome']; ?></b></h4>
										<h5 class="card-title">Movimentação Estoque</h5>
									</center>
									</br>
									
								</div>
								<div class="card-body table-responsive">
									
									<table class="table table-hover " id="lista">
										<tr>
											<th>Tipo</th>
											<th>Quantidade</th>											
											<th>Data</th>
											
										</tr>
										<?php
										// Loop para exibir as linhas
										if (!empty($linhas))
											foreach ($linhas as $exibir_colunas) {
												echo '<tr>';												
												echo '<th title="' . $exibir_colunas['tipo'] . '">' . $exibir_colunas['tipo'] . '</th>';
												echo '<td title="' . $exibir_colunas['quantidade'] . ' produto(s)">' . $exibir_colunas['quantidade'] . '</td>';
												echo '<td title="' . $exibir_colunas['data'] . '">' . date('d/m/Y H:i:s', strtotime($exibir_colunas['data'])) . '</td>';
												
												echo '</tr>';
											}
										?>
									</table>
									<a class="btn btn-danger pull-left" href="/web/form_crud/form_select_produto.php">Voltar</a>

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