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
	<title> UPDATE | CLIENTE </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Atualizar
		if(isset($_POST['Atualizar'])){	 
			// Especifica a variavel externa
			$cd_cliente = $_POST['cd_cliente'];
			$nome = $_POST['nome'];
			$cpf = $_POST['cpf']; // Constraint UNIQUE no BD
			$telefone = $_POST['telefone']; // Constraint UNIQUE no BD
			$email = $_POST['email']; // Constraint UNIQUE no BD
			$cidade = $_POST['cidade'];
			$bairro = $_POST['bairro'];
			$rua = $_POST['rua'];
			$numero = $_POST['numero'];

			// Query que verifica se existe cpf, telefone e email iguais de clientes
			$procurar_cliente = "SELECT COUNT(*) FROM cliente WHERE cd_cliente != :cd_cliente 
			AND (cpf = :cpf OR telefone = :telefone OR email = :email) LIMIT 1";
			$busca_cliente = $conexao->prepare($procurar_cliente);
			$busca_cliente->bindValue(':cd_cliente',$cd_cliente);
			$busca_cliente->bindValue(':cpf',$cpf);
			$busca_cliente->bindValue(':telefone',$telefone);
			$busca_cliente->bindValue(':email',$email);
			$busca_cliente->execute();
			$existe = $busca_cliente->fetchColumn();
			// Se existe cpf, telefone e email iguais do registro em outros registros
			if ($existe != 0) {
				$msg =  "Alguma informação de CPF, telefone ou e-mail pertence a outro cliente cadastrado, refaça a operação de atualização.";
				header('Location: /web/form_crud/form_update_cliente.php?id='.$cd_cliente.'&error='.$msg);
				exit;
			}

			// Se a atualizacao for possivel de realizar
			try {
				// Query que faz a atualizacao
				$atualizacao = "UPDATE cliente SET nome = :nome, cpf = :cpf,
				telefone = :telefone, email = :email, cidade = :cidade, 
				bairro = :bairro, rua = :rua, numero = :numero WHERE cd_cliente = :cd_cliente";
				// $atualiza_dados recebe $conexao que prepare a operacao de atualizacao
				$atualiza_dados = $conexao->prepare($atualizacao);
				// Vincula um valor a um parametro
				$atualiza_dados->bindValue(':cd_cliente',$cd_cliente);
				$atualiza_dados->bindValue(':nome', $nome);
				$atualiza_dados->bindValue(':cpf', $cpf);
				$atualiza_dados->bindValue(':telefone', $telefone);
				$atualiza_dados->bindValue(':email', $email);
				$atualiza_dados->bindValue(':cidade', $cidade);
				$atualiza_dados->bindValue(':bairro', $bairro);
				$atualiza_dados->bindValue(':rua', $rua);
				$atualiza_dados->bindValue(':numero', $numero);
			    // Executa a operacao
			    $atualiza_dados->execute();
			    // Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_select_cliente.php/#nome');
				die;	
			// Caso a atualizacao for possivel de realizar
			} catch (PDOException $falha_atualizacao) {
			    $msg =  "A atualização não foi feita".$falha_atualizacao->getMessage();
				header('Location: /web/form_crud/form_update_cliente.php?id='.$cd_cliente.'&error='.$msg);
			    die;
			} catch (Exception $falha) {
				$msg = "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_update_cliente.php?id='.$cd_cliente.'&error='.$msg);
				die;
			}
		// Caso nao exista
		} else {
			$msg =  "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_update_cliente.php?id='.$cd_cliente.'&error='.$msg);
			exit;
		} 	
	?>
</body>
</html>