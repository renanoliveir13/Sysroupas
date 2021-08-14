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
<html>
<head>
	<meta charset="utf-8">
	<title> UPDATE | FUNCIONÁRIO </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Atualizar
		if(isset($_POST['Atualizar'])){
			// Especifica a variavel 
			$cd_funcionario = $_POST['cd_funcionario'];
			$nome = $_POST['nome'];
			$cpf = $_POST['cpf']; // Constraint UNIQUE no BD
			$telefone = $_POST['telefone']; // Constraint UNIQUE no BD
			$email = $_POST['email']; // Constraint UNIQUE no BD

			// Query que verifica se existe cpf, telefone e email iguais de funcionarios
			$procurar_funcionario = "SELECT COUNT(*) FROM funcionario WHERE cd_funcionario != :cd_funcionario 
			AND (cpf = :cpf OR telefone = :telefone OR email = :email) LIMIT 1";
			$busca_funcionario = $conexao->prepare($procurar_funcionario);
			$busca_funcionario->bindValue(':cd_funcionario',$cd_funcionario);
			$busca_funcionario->bindValue(':cpf',$cpf);
			$busca_funcionario->bindValue(':telefone',$telefone);
			$busca_funcionario->bindValue(':email',$email);
			$busca_funcionario->execute();
			$existe = $busca_funcionario->fetchColumn();
			// Se existe cpf, telefone e email iguais do registro em outros registros
			if ($existe != 0) {
				$msg = "Alguma informação de CPF, telefone ou e-mail pertence a outro funcionário cadastrado, refaça a operação de atualização.";
				header('Location: /web/form_crud/form_update_funcionario.php?id='.$cd_funcionario.'&error='.$msg);

				exit;
			}

			// Se a atualizacao for possivel de realizar
			try {
				// Query que faz a atualizacao
				$atualizacao = "UPDATE funcionario SET nome = :nome, cpf = :cpf, 
				telefone = :telefone, email = :email WHERE cd_funcionario = :cd_funcionario";
				// $atualiza_dados recebe $conexao que prepare a operacao de atualizacao
				$atualiza_dados = $conexao->prepare($atualizacao);
				// Vincula um valor a um parametro
				$atualiza_dados->bindValue(':cd_funcionario',$cd_funcionario);
				$atualiza_dados->bindValue(':nome', $nome);
				$atualiza_dados->bindValue(':cpf', $cpf);
				$atualiza_dados->bindValue(':telefone', $telefone);
				$atualiza_dados->bindValue(':email', $email);
				// Caso altere o nome do usuario sera exibido seu novo nome na tela do sistema
				$_SESSION['nome_usuario'] = $nome;
			    // Executa a operacao
			    $atualiza_dados->execute();
			    // Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_select_funcionario.php/#nome');
				die;	
			// Caso a atualizacao for possivel de realizar
			} catch (PDOException $falha_atualizacao) {
			    echo "A atualização não foi feita".$falha_atualizacao->getMessage();
			    die;
			} catch (Exception $falha) {
				echo "Erro não característico do PDO".$falha->getMessage();
				die;
			}
		// Caso nao exista
		} else {
			echo "Ocorreu algum erro, refaça novamente a operação.";
			echo '<p><a href="../form_crud/form_update_funcionario.php/#atu_func" 
			title="Refazer operação"><button>Botão refazer operação</button></a></p>';
			exit;
		} 
	?>
</body>
</html>