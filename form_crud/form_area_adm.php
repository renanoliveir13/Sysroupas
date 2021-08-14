<?php
// Arquivo conexao.php
require_once '../conexao/conexao.php';
// Arquivo classe_usuario.php
require_once '../classe/classe_usuario.php';
$u = new Usuario();
$u->Verificar();

try {
	// Query que faz a selecao
	$selecao = "SELECT * FROM funcionario ORDER BY cd_funcionario";
	// $seleciona_dados recebe $conexao que prepare a operacao para selecionar
	$seleciona_dados = $conexao->prepare($selecao);
	// Executa a operacao
	$seleciona_dados->execute();
	// Retorna uma matriz contendo todas as linhas do conjunto de resultados
	$linhas = $seleciona_dados->fetchAll(PDO::FETCH_ASSOC);


	$seleciona_funcionario = $conexao->query("SELECT cd_funcionario, nome FROM funcionario 
	WHERE cargo != 'Administrador' ORDER BY cd_funcionario");
	// Resulta em uma matriz
	$resultado_funcionario = $seleciona_funcionario->fetchAll();
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
	<title>Aréa de administrador</title>
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
							<div class="card card- table-plain-bg">
								<div class="card-header ">
									<center>
										<h4 class="card-title">Área administrador (Atalho = Alt + w)</h4>
									</center>

								</div>
								<div class="card-body table-full-width table-responsive">
									<form class="mx-3" method="POST" id="area_adm" autocomplete="off" action="/web/crud/area_adm.php" onsubmit="exibirNome()">
										<div class="row">
											<div class="col-md-3 pr-1">
												<div class="form-group">
													<label>ID funcionário *</label>
													<select class="form-control" onclick="buscaDados()" name="cd_funcionario" id="cd_funcionario" required="" title="Caixa de seleção para escolher o funcionário" accesskey="w">
														<option value="" title="Por padrão a opção é vazia, escolha abaixo o funcionário"> Nenhum </option>
														<?php foreach ($resultado_funcionario as $v1) : ?>
															<option title="<?= $v1['nome'] ?>" value="<?= $v1['cd_funcionario'] ?>"><?= $v1['nome'] ?></option>
														<?php endforeach ?>
													</select>
												</div>
											</div>

										</div>
										<div class="row">
											<div class="col-md-3 pr-1">
												<div class="form-group">
													<label>Cargo atual *</label>
													<select class="form-control" name="cargo" id="cargo" required="" title="Campo com o cargo atual do funcionário" readonly="readonly" tabindex="-1" aria-disabled="true">
														<option value="" title="Por padrão a opção é vazia"> Nenhum </option>
														<option value="Atendente" title="Cargo atendente"> Cargo atendente </option>
														<option value="Gerente" title="Cargo gerente"> Cargo gerente </option>
													</select>
												</div>
											</div>

										</div>
										<div class="row">
											<div class="col-md-3 pr-1">
												<div class="form-group">
													<label>Novo cargo *</label>
													<select class="form-control" name="novo_cargo" required="" title="Campo para escolher o novo cargo do funcionário">
														<option value="" title="Por padrão a opção é vazia"> Nenhum </option>
														<option value="Atendente" title="Cargo atendente"> Atendente </option>
														<option value="Gerente" title="Cargo gerente"> Gerente </option>
														</select>
												</div>
											</div>
										</div>

										<button class="btn btn-danger btn-xs pull-left" name="Atualizar" title="Botão para atualizar cargo do funcionário"> Atualizar </button>
										<div class="clearfix"></div>
									</form>
									<?php if (!empty($_GET['error'])) { ?>

										<div class="mx-5 mt-3 alert alert-danger" role="alert">
											<?= $_GET['error']; ?>
										</div>
									<?php } ?>
									<table class="table table-hover">
										<tr>
											<th title="ID"> ID </th>
											<th title="Nome"> Nome </th>
											<th title="Cargo"> Cargo </th>
											<th title="CPF"> CPF </th>
											<th title="Telefone"> Telefone </th>
											<th title="Email"> Email </th>
										</tr>
										<?php
										// Loop para exibir as linhas
										foreach ($linhas as $exibir_colunas) {
											echo '<tr>';
											echo '<td title="' . $exibir_colunas['cd_funcionario'] . '">' . $exibir_colunas['cd_funcionario'] . '</td>';
											echo '<td title="' . $exibir_colunas['nome'] . '">' . $exibir_colunas['nome'] . '</td>';
											echo '<td title="' . $exibir_colunas['cargo'] . '">' . $exibir_colunas['cargo'] . '</td>';
											echo '<td title="' . substr_replace($exibir_colunas['cpf'], '***.***', 4, -3) . '">' . substr_replace($exibir_colunas['cpf'], '***.***', 4, -3) . '</td>';
											echo '<td title="' . $exibir_colunas['telefone'] . '">' . $exibir_colunas['telefone'] . '</td>';
											echo '<td title="' . substr_replace($exibir_colunas['email'], '****', 1, strpos($exibir_colunas['email'], '@')
												- 2) . '">' . substr_replace($exibir_colunas['email'], '****', 1, strpos($exibir_colunas['email'], '@') - 2) . '</td>';
											echo '
											<td class="actions">													
													<a class="btn btn-danger btn-xs"  style="border-radius: 20px;"href="/web/form_crud/form_delete_funcionarioarea.php?id=' . $exibir_colunas['cd_funcionario'] . '" >Excluir</a>
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
<script type="text/javascript" src="/web/js/funcionario/requisicao_adm.js"></script>
<script type="text/javascript" src="/web/js/alerta/alerta_adm.js" charset="UTF-8"></script>
<script type="text/javascript" src="/web/js/alerta/alerta_exclusao_usuario.js" charset="UTF-8"></script>

</html>