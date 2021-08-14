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
	header('Location: /web/form_crud/form_select_fornecedor/.php');
}

try {
	// Query que seleciona os dados do registro
	$query = $conexao->prepare("SELECT * FROM fornecedor WHERE cd_fornecedor = :id");
	$query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
	// Executa a operacao
	$query->execute();
	// Resulta em uma matriz
	$dados = $query->fetch(PDO::FETCH_ASSOC);

	//Verifica se houve retorno na query, se não, o cadastro não é válido e retorna o usuário para tela de listagem
	if (empty($dados)) {
		header('Location: /web/form_crud/form_select_fornecedor.php');
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
	<title>Cadastrar fornecedor</title>
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

				<!-- FORMULARIO -->
				<?php
				// Mostrar todos os erros do php
				ini_set('display_errors', '1');
				ini_set('display_startup_errors', '1');
				error_reporting(E_ALL);

				// Se a selecao for possivel de realizar
				try {
					// Query que seleciona chave e nome do fornecedor
					$seleciona_nomes = $conexao->query("SELECT cd_fornecedor, nome FROM fornecedor ORDER BY cd_fornecedor");
					// Resulta em uma matriz
					$resultado_selecao = $seleciona_nomes->fetchAll();
					// Se a selecao nao for possivel de realizar
				} catch (PDOException $falha_selecao) {
					echo "A listagem de dados não foi feita" . $falha_selecao->getMessage();
					die;
				} catch (Exception $falha) {
					echo "Erro não característico do PDO" . $falha->getMessage();
					die;
				}
				?>
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-8">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Atualizar fornecedor (Atalho = Alt + w)</h4>
								</div>
								<div class="card-body">
									<form method="POST" id="atu_forn" autocomplete="off" action="/web/crud/update_fornecedor.php" onsubmit="exibirNome()">
										<div class="row">
											<div class="col-md-6 pr-1">
												<div class="form-group">
													<label>ID fornecedor *</label>
													<input id="cd_fornecedor" name="cd_fornecedor" type="number" readonly class="form-control" title="Campo que mostra o registro de fornecedor" value="<?= $dados['cd_fornecedor']; ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 pr-1">
												<div class="form-group">
													<label>Nome *</label>
													<input id="nome" name="nome" type="text" class="form-control" placeholder="Ex: Trapos PHP" value="<?= $dados['nome']; ?>" required title="Campo para atualizar o nome do fornecedor">
												</div>
											</div>
											<div class="col-md-6 pl-1">
												<div class="form-group">
													<label for="form-control">CNPJ *</label>
													<input id="cnpj" name="cnpj" type="text" required class="form-control" value="<?= $dados['cnpj']; ?>" placeholder="Ex: 12.123.123/1234-12" title="Campo para atualizar o CPNJ do fornecedor">
												</div>
											</div>
										</div>


										<div class="row">
											<div class="col-md-6 pr-1">
												<div class="form-group">
													<label for="phone">Telefone *</label>
													<input id="telefone" name="telefone" type="text" class="form-control" value="<?= $dados['telefone']; ?>" placeholder="Ex: (99) 9999-9999" pattern="(\([0-9]{2}\))\s([0-9]{0-9})?([0-9]{4})-([0-9]{4})" title="Campo para atualizar o número de telefone do fornecedor" required="required" />
												</div>

											</div>
											<div class="col-md-6 pl-1">
												<div class="form-group">
													<label for="exampleInputEmail1">Email *</label>
													<input id="email" name="email" type="email" required title="Campo para atualizar o email do fornecedor" class="form-control" value="<?= $dados['email']; ?>" placeholder="Ex: trapos_php@gmail.com">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4">
												<label for="uf" class="control-label">Estado *</label>
												<select value="<?= $dados['estado']; ?>" id="estado" name="estado" class="form-control" required title="Caixa de seleção para atualizar o estado do fornecedor">
												<option value="" title="Escolha o estado">Escolha o estado</option>
                                                    <option value="AC" title="Acre">Acre</option>
                                                    <option value="AL" title="Alagoas">Alagoas</option>
                                                    <option value="AM" title="Amazonas">Amazonas</option>
                                                    <option value="AP" title="Amapá">Amapá</option>
                                                    <option value="BA" title="Bahia">Bahia</option>
                                                    <option value="CE" title="Ceará">Ceará</option>
                                                    <option value="DF" title="Distrito Federal">Distrito Federal</option>
                                                    <option value="ES" title="Espírito Santo">Espiríto Santo</option>
                                                    <option value="GO" title="Goiás">Goiás</option>
                                                    <option value="MA" title="Maranhão">Maranhão</option>
                                                    <option value="MG" title="Minas Gerais">Minas Gerais</option>
                                                    <option value="MS" title="Mato Grosso do Sul">Mato Grosso do Sul</option>
                                                    <option value="MT" title="Mato Grosso">Mato Grosso</option>
                                                    <option value="PA" title="Paraíba">Paraíba</option>
                                                    <option value="PE" title="Pernambuco">Pernambuco</option>
                                                    <option value="PI" title="Piauí">Piauí</option>
                                                    <option value="PR" title="Paraná">Paraná</option>
                                                    <option value="RJ" title="Rio de Janeiro">Rio de Janeiro</option>
                                                    <option value="RN" title="Rio Grande do Norte">Rio Grande do Norte</option>
                                                    <option value="RO" title="Rondônia">Rondônia</option>
                                                    <option value="RR" title="Roraima">Roraima</option>
                                                    <option value="RS" title="Rio Grande do Sul">Rio Grande do Sul</option>
                                                    <option value="SC" title="Santa Catarina">Santa Catarina</option>
                                                    <option value="SE" title="Sergipe">Sergipe</option>
                                                    <option value="SP" title="Sergipe">Sergipe</option>
                                                    <option value="TO" title="Tocantins">Tocantins</option>
												</select>
											</div>
										</div>
										<?php
										echo '<script>document.getElementById("estado").value = "' . $dados['estado'] . '"</script>';
										?>
										<div class="row">
											<div class="col-md-6 pr-1">
												<div class="form-group">
													<label>Cidade *</label>
													<input id="cidade" name="cidade" type="text" value="<?= $dados['cidade']; ?>" class="form-control" placeholder="" required title="Campo para atualizar a cidade do fonnecedor">
												</div>
											</div>
											<div class="col-md-6 pl-1">
												<div class="form-group">
													<label>Bairro *</label>
													<input id="bairro" name="bairro" type="text" value="<?= $dados['bairro']; ?>" class="form-control" placeholder="" required title="Campo para atualizar o bairro do fornecedor">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-4 pr-1">
												<div class="form-group">
													<label>Rua *</label>
													<input id="endereco" name="endereco" value="<?= $dados['endereco']; ?>" type="text" class="form-control" placeholder="" required title="Campo para atualizar o endereço do fornecedor">
												</div>
											</div>
											<div class="col-md-4 px-1">
												<div class="form-group">
													<label>Número *</label>
													<input id="numero" name="numero" type="text" value="<?= $dados['numero']; ?>" class="form-control" placeholder="" required title="Campo para atualizar o número do comércio do fornecedor">
												</div>
											</div>

										</div>
										<?php if (!empty($_GET['error'])) { ?>

											<div class="alert alert-danger" role="alert">
												<?= $_GET['error']; ?>
											</div>
										<?php } ?>
										<a class="btn btn-danger pull-left" href="/web/form_crud/form_select_fornecedor.php">Voltar</a>
										<button type="submit" name="Atualizar" class="btn btn-round btn-fill btn-info btn pull-right">Atualizar</button>

										<div class="clearfix"></div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
				<!-- <form method="POST" id="atu_forn" autocomplete="off" action="/web/crud/update_fornecedor.php" onsubmit="exibirNome()">
					<fieldset>
						<legend> Atualizar fornecedor (Atalho = Alt + w) </legend>
						<p> Escolha o fornecedor:
							<select onclick="buscaDados()" name="cd_fornecedor" id="cd_fornecedor" required="" title="Caixa de seleção para escolher o fornecedor a ser atualizado" accesskey="w">
								<option value="" title="Opção vazia, escolha abaixo o fornecedor a ser atualizado"> Nenhum </option>
								<?php foreach ($resultado_selecao as $valor) : ?>
									<option title="<?= $valor['nome'] ?>" value="<?= $valor['cd_fornecedor'] ?>"><?= $valor['nome'] ?></option>
								<?php endforeach ?>
							</select>
						</p>
						<p> Nome: <input type="text" name="nome" id="nome" title="Campo para atualizar o nome do fornecedor" size="30" maxlength="30" required=""> </p>
						<p> CNPJ: <input type="text" name="cnpj" id="cnpj" title="Campo para atualizar o CNPJ do fornecedor" size="30" minlength="18" required=""> </p>
						<p> Telefone: <input type="text" name="telefone" title="Campo para atualizar o telefone do fornecedor" id="telefone" size="30" minlength="14" required=""> </p>
						<p> Email: <input type="email" name="email" title="Campo para atualizar o email do fornecedor" id="email" size="30" maxlength="50" required=""> </p>
						<p> Estado: <input type="text" name="estado" title="Campo para atualizar o estado do fornecedor" id="estado" size="30" maxlength="30" required=""> </p>
						<p> Cidade: <input type="text" name="cidade" title="Campo para atualizar a cidade do fornecedor" id="cidade" size="30" maxlength="30" required=""> </p>
						<p> Bairro: <input type="text" name="bairro" title="Campo para atualizar o bairro do fornecedor" id="bairro" size="30" maxlength="30" required=""> </p>
						<p> Rua: <input type="text" title="Campo para atualizar a rua do fornecedor" name="endereco" id="endereco" size="30" maxlength="30" required=""> </p>
						<p> Número: <input type="number" name="numero" id="numero" pattern="\d+" title="Campo para atualizar o número do comércio do fornecedor" size="5" required=""> </p>
						<button name="Atualizar" title="Botão para atualizar fornecedor"> Botão atualizar fornecedor </button>
					</fieldset>
				</form> -->
				
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
<script type="text/javascript" src="/web/js/fornecedor/mascara_fornecedor.js"></script>
<script type="text/javascript" src="/web/js/fornecedor/requisicao_fornecedor.js"></script>
<script type="text/javascript" src="/web/js/alerta/alerta_update.js" charset="UTF-8"></script>

</html>