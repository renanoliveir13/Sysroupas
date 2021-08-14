<?php
	// Arquivo conexao.php
	require_once '../conexao/conexao.php'; 
	// Arquivo classe_usuario.php
	require_once '../classe/classe_usuario.php';
	
	$u =  new Usuario();
	$u->Verificar();

	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> UPDATE | ÁREA ADMINISTRADOR </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Atualizar
		if(isset($_POST['Atualizar'])){
			// Especifica a variavel 
			$cd_funcionario = $_POST['cd_funcionario'];
			$cargo_atual = $_POST['cargo'];
			$novo_cargo = $_POST['novo_cargo'];

			$procurar_funcionario = "SELECT nome FROM funcionario WHERE cd_funcionario = :cd_funcionario LIMIT 1";
			$busca_funcionario = $conexao->prepare($procurar_funcionario);
			$busca_funcionario->bindValue(':cd_funcionario', $cd_funcionario);
			$busca_funcionario->execute();
			$linha = $busca_funcionario->fetch(PDO::FETCH_ASSOC);
			$nome_funcionario = $linha['nome'];

			// Se o cargo atual for igual ao novo cargo
			if ($cargo_atual == $novo_cargo) {
				$msg = "O novo cargo de {$nome_funcionario} não pode ser igual ao antigo cargo, refaça a operação.";
				header('Location: /web/form_crud/form_area_adm.php?&error='.$msg);

				exit;
			}
			// Se a atualizacao for possivel de realizar
			try {
				// Query que faz a atualizacao
				$atualizacao = "UPDATE funcionario SET cargo = :novo_cargo WHERE cd_funcionario = :cd_funcionario";
				// $atualiza_dados recebe $conexao que prepare a operacao de atualizacao
				$atualiza_dados = $conexao->prepare($atualizacao);
				// Vincula um valor a um parametro
				$atualiza_dados->bindValue(':cd_funcionario',$cd_funcionario);
				$atualiza_dados->bindValue(':novo_cargo', $novo_cargo);
			    // Executa a operacao
			    $atualiza_dados->execute();
			    // Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_area_adm.php/#area_adm');
				die;	
			// Caso a atualizacao for possivel de realizar
			} catch (PDOException $falha_atualizacao) {
			    $msg = "A atualização não foi feita".$falha_atualizacao->getMessage();
				header('Location: /web/form_crud/form_area_adm.php?&error='.$msg);
			    die;
			} catch (Exception $falha) {
				$msg = "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_area_adm.php?&error='.$msg);
				die;
			}
		// Caso nao exista
		} else {
			$msg = "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_area_adm.php?&error='.$msg);
			exit;
		} 
	?>
</body>
</html>