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
	<title>Listar clientes</title>
	 <link rel="stylesheet" href="/web/css/estiloBotao.css"/>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<?php include(dirname(__FILE__) . '/../layout/css.php'); ?>
</head>

<body>

	<?php
	// Se a selecao for possivel de realizar
	try {
		// Query que faz a selecao
		$selecao = "SELECT * FROM cliente ORDER BY cd_cliente";
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
							<div class="card card- table-plain-bg">
								<div class="card-header ">
									<center>
										<h4 class="card-title">Listar clientes (Atalho = Alt + w)</h4>
									</center>
									</br>
								</div>
								<fieldset class="mx-2 col-md-6">
										<input id="nome" class="form-control" pace accesskey="w" title="Campo para procurar determinado cliente pelo nome" placeholder="Buscar cliente"/>
									</fieldset>
								<div class="card-body table-full-width table-responsive">
									<table class="table table-hover" id="lista">
										<tr>
											<th title="ID"> ID </th>
											<th title="Nome"> Nome </th>
											<th title="CPF"> CPF </th>
											<th title="Telefone"> Telefone </th>
											<th title="Email"> Email </th>
											<th title="Cidade"> Cidade </th>
											<th title="Bairro"> Bairro </th>
											<th title="Rua"> Rua </th>
											<th title="Número"> Número </th>
											<th title="Ações"> Ações </th>
										</tr>
										<?php
										// Loop para exibir as linhas
										foreach ($linhas as $exibir_colunas) {
											echo '<tr>';
											echo '<td title="' . $exibir_colunas['cd_cliente'] . '">' . $exibir_colunas['cd_cliente'] . '</td>';
											echo '<td title="' . $exibir_colunas['nome'] . '">' . $exibir_colunas['nome'] . '</td>';
											echo '<td title="' . substr_replace($exibir_colunas['cpf'], '***.***', 4, -3) . '">' . substr_replace($exibir_colunas['cpf'], '***.***', 4, -3) . '</td>';
											echo '<td title="' . $exibir_colunas['telefone'] . '">' . $exibir_colunas['telefone'] . '</td>';
											echo '<td title="' . $exibir_colunas['email'] . '">' . $exibir_colunas['email'] . '</td>';
											echo '<td title="' . $exibir_colunas['cidade'] . '">' . $exibir_colunas['cidade'] . '</td>';
											echo '<td title="' . $exibir_colunas['bairro'] . '">' . $exibir_colunas['bairro'] . '</td>';
											echo '<td title="' . $exibir_colunas['rua'] . '">' . $exibir_colunas['rua'] . '</td>';
											echo '<td title="' . $exibir_colunas['numero'] . '">' . $exibir_colunas['numero'] . '</td>';
											// echo '<td>' . "<a href='/web/form_crud/form_insert_fornecedor.php/#cad_forn' title='Cadastrar fornecedor'>Cadastrar</a> " .
											// 	"<a href='/web/form_crud/form_update_fornecedor.php/#atu_forn' title='Atualizar fornecedor'>Atualizar</a> " .
											// 	"<a href='/web/form_crud/form_delete_fornecedor.php/#exc_forn' title='Deletar fornecedor'>Excluir</a>" . '</td>';
											echo '
											<td class="actions">													
													<a class="btn btn-primary " style="border-radius: 20px;" <a href="/web/form_crud/form_update_cliente.php?id=' . $exibir_colunas['cd_cliente'] . '">Atualizar</a>
													<a class="btn btn-danger btn-xs"  style="border-radius: 20px;"href="/web/form_crud/form_delete_cliente.php?id=' . $exibir_colunas['cd_cliente'] . '" >Excluir</a>
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
	<script type="text/javascript" src="/web/js/cliente/select_cliente.js"></script>

</body>
<?php include(dirname(__FILE__) . '/../layout/js.php'); ?>

</html>