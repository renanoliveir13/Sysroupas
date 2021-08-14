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
	header('Location: /web/form_crud/form_select_produto.php');
}

try {
	// Query que seleciona os dados do registro
	$query = $conexao->prepare("SELECT * FROM compra_produto WHERE cd_produto = :id");
	$query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
	// Executa a operacao
	$query->execute();
	// Resulta em uma matriz
	$dados = $query->fetch(PDO::FETCH_ASSOC);


	//Query que seleciona chave e nome do fornecedor
	$seleciona_fornecedor = $conexao->query("SELECT cd_fornecedor, nome FROM fornecedor ORDER BY cd_fornecedor");
	// Resulta em uma matriz
	$resultado_fornecedor = $seleciona_fornecedor->fetchAll();

	//Verifica se houve retorno na query, se não, o cadastro não é válido e retorna o usuário para tela de listagem
	if (empty($dados)) {
		header('Location: /web/form_crud/form_select_produto.php');
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
	<title>Atualizar produto</title>
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
									<h4 class="card-title">Atualizar produto (Atalho = Alt + w)</h4>
								</div>
								<div class="card-body">
									<form method="POST" id="atu_forn" autocomplete="off" action="/web/crud/update_produto.php">
										<div class="row">
											<div class="col-md-4 pr-1">
												<div class="form-group">
													<label>ID produto *</label>
													<input type="number" name="cd_produto" readonly class="form-control" placeholder="" value="<?= $dados['cd_produto']; ?>" accesskey="w" title="Campo que mostra o registro do produto">
												</div>
											</div>
										</div>										
										<div class="row">
												<div class="col-md-6 pr-1">
													<div class="form-group">
														<label>Descrição *</label>
														<input type="text" name="descricao" value="<?= $dados['nome']; ?>" title="Campo para atualizar a descrição do produto" id="descricao" class="form-control" placeholder="" required>
													</div>
												</div>
											</div>
										<div class="row">
											<div class="col-md-6 pr-1">
												<div class="form-group">
													<label>Tipo da roupa *</label>
													<select class="form-control" name="tipo" id="tipo" required="" title="Caixa de seleção para atualizar o tipo da roupa" class="form-control" placeholder="">
														<option value="">Escolha a roupa</option>
														<option value="Camiseta">Camiseta</option>
														<option value="Calça">Calça</option>
														<option value="Bermuda">Bermuda</option>
														<option value="Jaqueta">Jaqueta</option>
														<option value="Saia">Saia</option>
														<option value="Macacão">Macacão</option>
														<option value="Vestido">Vestido</option>

													</select>
													<?php echo '<script>document.getElementById("tipo").value = "' . $dados['tipo'] . '"</script>'; ?>

												</div>
											</div>
											<div class="col-md-6 pl-1">
												<div class="form-group">
													<label for="exampleInputEmail1">Marca *</label>
													<select class="form-control" name="marca" id="marca" required="" title="Caixa de seleção para atualizar o tipo do produto" class="form-control">
														<option value="">Escolha a marca</option>
														<option value="Lacoste">Lacoste</option>
														<option value="Hollister">Hollister</option>
														<option value="Polo Ralph Lauren">Polo Ralph Lauren</option>
														<option value="TOMMY HILFIGER">TOMMY HILFIGER</option>
														<option value="Calvin Klein">Calvin Klein</option>
														<option value="Colcci">Colcci</option>
														<option value="John John">John John</option>
														<option value="Dudalina">Dudalina</option>
														<option value="Louis Vuitton">Louis Vuitton</option>
														<option value="FARM">FARM</option>

													</select>
													<?php echo '<script>document.getElementById("marca").value = "' . $dados['marca'] . '"</script>'; ?>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 pr-1">
												<div class="form-group">
													<label>Código de Barra *</label>
													<input type="text" class="form-control" name="codigo_barra" onkeypress="$(this).mask('0-000000-000000')" value="<?= $dados['codigo_barra']; ?>" required title="Campo para atualizar o código de barra do produto">
												</div>
											</div>
											<div class="col-md-6 pl-1">
												<div class="form-group">
													<label for="exampleInputEmail1">Cor *</label>

													<select class="form-control" name="cor" id="cor" required="" title="Caixa de seleção para atualizar a cor do produto" class="form-control" placeholder="">
														<option value="">Escolha a cor</option>
														<option value="Preta">Preto</option>
														<option value="Cinza">Cinza</option>
														<option value="Branca">Branco</option>
														<option value="Vermelha">Vermelho</option>
														<option value="Amarela">Amarelo</option>
														<option value="Azul">Azul</option>
														<option value="Verde">Verde</option>
														<option value="Laranja">Laranja</option>
														<option value="Rosa">Rosa</option>
														<option value="Vinho">Vinho</option>
														<option value="Marron">Marron</option>
														<option value="Roxa">Roxo</option>

													</select>
													<?php echo '<script>document.getElementById("cor").value = "' . $dados['cor'] . '"</script>'; ?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 pr-1">
												<div class="form-group">
													<label>Tamanho *</label>
													<select class="form-control" name="tamanho" id="tamanho" required="" title="Caixa de seleção para atualizar o tamanho do produto" class="form-control">
														<option value="">Escolha o tamanho</option>
														<option value="P">P</option>
														<option value="M">M</option>
														<option value="G">G</option>
														<option value="GG">GG</option>

													</select>
													<?php echo '<script>document.getElementById("tamanho").value = "' . $dados['tamanho'] . '"</script>'; ?>
												</div>
											</div>

										</div>
										<div class="row">
											<div class="col-md-6 pr-1">
												<div class="form-group">
													<label>Gênero *</label>

													<select class="form-control" name="genero" id="genero" required="" title="Caixa de seleção para atualizar o gênero do produto" class="form-control">
													<option value="">Escolha o gênero</option>
														<option value="M">Masculino</option>
														<option value="F">Feminino</option>

													</select>
													<?php echo '<script>document.getElementById("genero").value = "' . $dados['genero'] . '"</script>'; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6 pl-1">
											<div class="form-group">
												<label>Quantidade *</label>
												<input type="number" readonly class="form-control" placeholder="" name="quantidade" value="<?= $dados['quantidade']; ?>" required title="Campo para atualizar a quantidade de produtos">
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 pr-1">
												<div class="form-group">
													<label>Valor da compra *</label>
													<input type="text" onkeypress="$(this).mask('00000.00', {reverse:true})" class="form-control" placeholder="R$" name="valor_compra" value="<?= $dados['valor_compra']; ?>" required title="Campo para atualizar o valor de compra do produto">
												</div>
											</div>
											<div class="col-md-4 px-1">
												<div class="form-group">
													<label>Porcentagem da revenda *</label>

													<select class="form-control" name="porcentagem_revenda" id="porcentagem_revenda" value="<?= $dados['porcentagem_revenda']; ?>" required="" title="Caixa de seleção para atualizar a porcentagem de revenda do produto" class="form-control" placeholder="">

														<option value="">Escolha a porcentagem</option>
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
													<?php
													echo '<script>document.getElementById("porcentagem_revenda").value = "' . $dados['porcentagem_revenda'] . '"</script>';
													?>
												</div>
											</div>

										</div>
										<?php if (!empty($_GET['error'])) { ?>

											<div class="alert alert-danger" role="alert">
												<?= $_GET['error']; ?>
											</div>
										<?php } ?>
										<a class="btn btn-danger pull-left" href="/web/form_crud/form_select_produto.php">Voltar</a>
										<button type="submit" name="Atualizar" class="btn btn-round btn-fill btn-info pull-right">Atualizar</button>

										<div class="clearfix"></div>
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
		<button href="#" onclick='window.scrollTo({top: 0, behavior: "smooth"})' title="Botão voltar ao topo">Topo da página</button>

	</div>

</body>
<?php include(dirname(__FILE__) . '/../layout/js.php'); ?>
<script type="text/javascript" src="/web/js/produto/mascara_produto.js"></script>
<script type="text/javascript" src="/web/js/produto/requisicao_produto.js"></script>
<script type="text/javascript" src="/web/js/alerta/alerta_update.js" charset="UTF-8"></script>

</html>