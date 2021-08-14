<?php
	// Arquivo conexao.php
	require_once '../conexao/conexao.php'; 
	// Arquivo classe_usuario.php
	require_once '../classe/classe_usuario.php';

	// Verifica usuário logado
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
	<title> INSERT | FUNCIONÁRIO </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Inserir
		if (isset($_POST['Inserir'])) {
			// Especifica a variavel
			$nome = $_POST['nome'];
			$cargo = $_POST['cargo'];
			$cpf = $_POST['cpf']; // Constraint UNIQUE no BD
			$telefone = $_POST['telefone']; // Constraint UNIQUE no BD
			$email = $_POST['email']; // Constraint UNIQUE no BD
			$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

			// Query que verifica se existe cpf, telefone e email iguais de funcionario
			$procurar_funcionario = "SELECT COUNT(*) FROM funcionario WHERE cpf = :cpf OR telefone = :telefone OR email = :email LIMIT 1";
			$busca_funcionario = $conexao->prepare($procurar_funcionario);
			$busca_funcionario->bindValue(':cpf',$cpf);
			$busca_funcionario->bindValue(':telefone',$telefone);
			$busca_funcionario->bindValue(':email',$email);
			$busca_funcionario->execute();
			$existe = $busca_funcionario->fetchColumn();
			// Se existe cpf, telefone e email iguais de funcionarios
			if ($existe != 0) {
				$msg= "Alguma informação de CPF, telefone ou e-mail pertence a outro funcionário cadastrado, refaça a operação de inserção.";
				header('Location: /web/form_crud/form_insert_funcionario.php?&error='.$msg);
				exit;
			}

			// Se a insercao for possivel de realizar
			try {
				// Query que faz a insercao
				$insercao = "INSERT INTO funcionario (nome,cargo,cpf,telefone,email,senha) 
				VALUES (:nome,:cargo,:cpf,:telefone,:email,:senha)";
				// $insere_dados recebe $conexao que prepare a operacao de insercao
				$insere_dados = $conexao->prepare($insercao);
				// Vincula um valor a um parametro
				$insere_dados->bindValue(':nome', $nome);
				$insere_dados->bindValue(':cargo', $cargo);
				$insere_dados->bindValue(':cpf', $cpf);
				$insere_dados->bindValue(':telefone', $telefone);
				$insere_dados->bindValue(':email', $email);
				$insere_dados->bindValue(':senha', $senha);
				// Executa a operacao
				$insere_dados->execute();
				// Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_select_funcionario.php/#nome');
				die;
				// Se a insercao nao for possivel de realizar
			} catch (PDOException $falha_insercao) {
				$msg = "A inserção não foi feita" . $falha_insercao->getMessage();
				header('Location: /web/form_crud/form_insert_funcionario.php?&error='.$msg);
				die;
			} catch (Exception $falha) {
				$msg =  "Erro não característico do PDO" . $falha->getMessage();
				header('Location: /web/form_crud/form_insert_funcionario.php?&error='.$msg);
				die;
			}
		// Caso nao exista
		} else {
			$msg = "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_insert_funcionario.php?&error='.$msg);
			exit;
		} 
	?>
</body>
</html>