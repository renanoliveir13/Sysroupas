<?php
// Arquivo conexao.php
require_once '../conexao/conexao.php';
// Arquivo classe_usuario.php
require_once '../classe/classe_usuario.php';
// Inicio da sessao

$u = new Usuario();
$u->Verificar();

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
	<title>Excluindo Fornecedor</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

</head>

<body>
	<div class="wrapper">
		
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
					<?php
					// Se existir o botao de Deletar
					if (isset($_POST['Deletar'])) {
						// Especifica a variavel
						$cd_fornecedor = $_POST['cd_fornecedor'];
						// Se a remocao for possivel de realizar
						try {
							// Query que faz a remocao
							$remove = "DELETE FROM fornecedor WHERE cd_fornecedor = :cd_fornecedor";
							// $remocao recebe $conexao que prepare a operação de exclusao
							$remocao = $conexao->prepare($remove);
							// Vincula um valor a um parametro
							$remocao->bindValue(':cd_fornecedor', $cd_fornecedor);
							// Executa a operacao
							$remocao->execute();
							// Retorna para a pagina de formulario de listagem
							header('Location: ../form_crud/form_select_fornecedor.php/#nome');
							die;
							// Se a remocao nao for possivel de realizar
						} catch (PDOException $falha_remocao) {
							$msg = "A remoção não foi feita" . $falha_remocao->getMessage();
							header('Location: /web/form_crud/form_delete_fornecedor.php?id='.$cd_fornecedor.'&error='.$msg);
							die();
						} catch (Exception $falha) {
							$msg= "Erro não característico do PDO" . $falha->getMessage();
							header('Location: /web/form_crud/form_delete_fornecedor.php?id='.$cd_fornecedor.'&error='.$msg);
							die();
						}
						// Caso nao exista
					} else {
						$msg = "Ocorreu algum erro, refaça novamente a operação.";
						header('Location: /web/form_crud/form_delete_fornecedor.php?id='.$cd_fornecedor.'&error='.$msg);
						die();
					}
					?>

				</div>
			</div>
		</div>
		<button href="#" onclick='window.scrollTo({top: 0, behavior: "smooth"})' title="Botão voltar ao topo">Topo da página</button>

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

</html>