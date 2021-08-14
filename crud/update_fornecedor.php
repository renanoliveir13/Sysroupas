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
<html>
<head>
	<meta charset="utf-8">
	<title> UPDATE | FORNECEDOR </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Atualizar
		if(isset($_POST['Atualizar'])){	
			// Especifica a variavel
			$cd_fornecedor = $_POST['cd_fornecedor'];
			$nome = $_POST['nome'];
			$cnpj = $_POST['cnpj']; // Constraint UNIQUE no BD
			$telefone = $_POST['telefone']; // Constraint UNIQUE no BD
			$email = $_POST['email']; // Constraint UNIQUE no BD
			$estado = $_POST['estado'];
			$cidade = $_POST['cidade'];
			$bairro = $_POST['bairro'];
			$endereco = $_POST['endereco'];
			$numero = $_POST['numero'];

			// Query que verifica se existe cpf, telefone e email iguais de fornecedores
			$procurar_fornecedor = "SELECT COUNT(*) FROM fornecedor WHERE cd_fornecedor != :cd_fornecedor 
			AND (cnpj = :cnpj OR telefone = :telefone OR email = :email) LIMIT 1";
			$busca_fornecedor = $conexao->prepare($procurar_fornecedor);
			$busca_fornecedor->bindValue(':cd_fornecedor',$cd_fornecedor);
			$busca_fornecedor->bindValue(':cnpj',$cnpj);
			$busca_fornecedor->bindValue(':telefone',$telefone);
			$busca_fornecedor->bindValue(':email',$email);
			$busca_fornecedor->execute();
			$existe = $busca_fornecedor->fetchColumn();
			// Se existe cpf, telefone e email iguais do registro em outros registros
			if ($existe != 0) {
				$msg = "Alguma informação de CNPJ, telefone ou e-mail pertence a outro fornecedor cadastrado, refaça a operação de atualização.";
				header('Location: /web/form_crud/form_update_fornecedor.php?id='.$cd_fornecedor.'&error='.$msg);
				exit;
			}

			// Se a atualizacao for possivel de realizar
			try {
				// Query que faz a atualizacao
				$atualizacao = "UPDATE fornecedor SET nome = :nome, cnpj = :cnpj, 
				telefone = :telefone, email = :email, estado = :estado, cidade = :cidade,
				bairro = :bairro, endereco = :endereco, numero = :numero 
				WHERE cd_fornecedor = :cd_fornecedor";
				// $atualiza_dados recebe $conexao que prepare a operacao de atualizacao
				$atualiza_dados = $conexao->prepare($atualizacao);
				// Vincula um valor a um parametro
				$atualiza_dados->bindValue(':cd_fornecedor', $cd_fornecedor);
				$atualiza_dados->bindValue(':nome', $nome);
				$atualiza_dados->bindValue(':cnpj', $cnpj);
				$atualiza_dados->bindValue(':telefone', $telefone);
				$atualiza_dados->bindValue(':email', $email);
				$atualiza_dados->bindValue(':estado', $estado);
				$atualiza_dados->bindValue(':cidade', $cidade);
				$atualiza_dados->bindValue(':bairro', $bairro);
				$atualiza_dados->bindValue(':endereco', $endereco);
			    $atualiza_dados->bindValue(':numero', $numero);
			    // Executa a operacao
			    $atualiza_dados->execute();
			    // Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_select_fornecedor.php/#nome');
				die;	
			// Caso a atualizacao for possivel de realizar
			} catch (PDOException $falha_atualizacao) {
			    $msg = "A atualização não foi feita".$falha_atualizacao->getMessage();
				header('Location: /web/form_crud/form_update_fornecedor.php?id='.$cd_fornecedor.'&error='.$msg);
			    die;
			} catch (Exception $falha) {
				$msg = "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_update_fornecedor.php?id='.$cd_fornecedor.'&error='.$msg);
				die;
			}
		// Caso nao exista
		} else {
			$msg = "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_update_fornecedor.php?id='.$cd_fornecedor.'&error='.$msg);
			exit;
		} 
	?>
</body>
</html>