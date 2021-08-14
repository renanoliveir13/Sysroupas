<?php
	// Arquivo conexao.php
	require_once '../conexao/conexao.php'; 
	// Arquivo classe_usuario.php
	require_once '../classe/classe_usuario.php';
	// Inicio da sessao
	session_start();
	// Se existir $_SESSION['id_usuario'] e nao for vazio
	if((isset($_SESSION['id_usuario'])) && (!empty($_SESSION['id_usuario']))){
		// Mensagem
		echo "";
	// Se nao
	} else {
		// Retorna para a pagina index.php
		echo "<script> alert('Ação inválida, entre no sistema da maneira correta.'); location.href='/web/index.php' </script>";
		die;
	}
	// Caso o usuario atual seja diferente de ADM
	if ($_SESSION['cargo_usuario'] != "Administrador") {
		echo "<script> alert('Só o administrador pode acessar essa área.'); location.href='/web/inicio.php' </script>";
		die;
	}
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> DELETE | USUÁRIO </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Deletar
		if(isset($_POST['Deletar'])){
			// Especifica a variavel
			$cd_funcionario = $_POST['cd_funcionario'];
			// Query que verifica se o funcionário fez alguma venda
			$procurar_key = "SELECT COUNT(cd_venda) AS countFuncionario FROM venda WHERE cd_funcionario = :cd_funcionario";
			$busca_key = $conexao->prepare($procurar_key);
			$busca_key->bindValue(':cd_funcionario',$cd_funcionario);
			$busca_key->execute();
			$linha2 = $busca_key->fetch(PDO::FETCH_ASSOC);
			$countFuncionario = $linha2['countFuncionario'];
			// Se o registro de venda existir na tabela devolucao 
			if ($countFuncionario > 0) {
				$pluralSingular = $countFuncionario == 1 ? "uma venda" : "$countFuncionario vendas";
				echo "Você não pode excluir este funcionário, pois ele realizou $pluralSingular no sistema.";
				echo '<p><a href="../form_crud/form_area_adm.php/#area_adm" 
				title="Refazer operação"><button>Botão refazer operação</button></a></p>';
				exit;
			}
			// Se a remocao for possivel de realizar
			try {
			    // Query que faz a remocao
			    $remove = "DELETE FROM funcionario WHERE cd_funcionario = :cd_funcionario";
			    // $remocao recebe $conexao que prepare a operacao de exclusao
			    $remocao = $conexao->prepare($remove);
			    // Vincula um valor a um parametro
			    $remocao->bindValue(':cd_funcionario', $cd_funcionario);
			    // Executa a operacao
			    $remocao->execute();
			    // Redireciona para a pagina de listagem de funcionarios
			    header('Location: ../form_crud/form_select_funcionario.php/#nome');
			    die;
			// Se a remocao nao for possivel de realizar
			} catch (PDOException $falha_remocao) {
			    echo "A remoção não foi feita".$falha_remocao->getMessage();
			    die;
			} catch (Exception $falha) {
				echo "Erro não característico do PDO".$falha->getMessage();
				die;
			}
		// Caso nao exista
		} else {
			echo "Ocorreu algum erro, refaça novamente a operação.";
			echo '<p><a href="../form_crud/form_area_adm.php/#area_adm" 
			title="Refazer operação"><button>Botão refazer operação</button></a></p>';
			exit;
		} 	
	?>
</body>
</html>