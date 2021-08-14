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
	<title> INSERT | FORNECEDOR </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Inserir
		if(isset($_POST['Inserir'])){
			// Especifica a variavel
			$nome = $_POST['nome'];
			$cnpj = $_POST['cnpj']; // Constraint UNIQUE no BD
			$telefone = $_POST['telefone']; // Constraint UNIQUE no BD
			$email = $_POST['email']; // Constraint UNIQUE no BD
			$estado = $_POST['estado'];
			$cidade = $_POST['cidade'];
			$bairro = $_POST['bairro'];
			$endereco = $_POST['endereco'];
			$numero = $_POST['numero'];

			// Query que verifica se existe cnpj, telefone e email iguais de um fornecedor
			$procurar_fornecedor = "SELECT COUNT(*) FROM fornecedor WHERE cnpj = :cnpj OR telefone = :telefone OR email = :email LIMIT 1";
			$busca_fornecedor = $conexao->prepare($procurar_fornecedor);
			$busca_fornecedor->bindValue(':cnpj',$cnpj);
			$busca_fornecedor->bindValue(':telefone',$telefone);
			$busca_fornecedor->bindValue(':email',$email);
			$busca_fornecedor->execute();
			$existe = $busca_fornecedor->fetchColumn();
			// Se existe cpf, telefone e email iguais de fornecedores
			if ($existe != 0) {
				$msg = "Alguma informação de CNPJ, telefone ou e-mail pertence a outro fornecedor cadastrado, refaça a operação de inserção.";
				header('Location: /web/form_crud/form_insert_fornecedor.php?error='.$msg);
				exit;
			}

			// Se a insercao for possivel de realizar
			try {
				// Query que faz a insercao
				$insercao = "INSERT INTO fornecedor (nome,cnpj,telefone,email,estado,cidade,bairro,endereco,numero) 
				VALUES (:nome,:cnpj,:telefone,:email,:estado,:cidade,:bairro,:endereco,:numero)";
				// $insere_dados recebe $conexao que prepare a operacao de insercao
				$insere_dados = $conexao->prepare($insercao);
				// Vincula um valor a um parametro
				$insere_dados->bindValue(':nome', $nome);
				$insere_dados->bindValue(':cnpj', $cnpj);
				$insere_dados->bindValue(':telefone', $telefone);
				$insere_dados->bindValue(':email', $email);
				$insere_dados->bindValue(':estado', $estado);
				$insere_dados->bindValue(':cidade', $cidade);
				$insere_dados->bindValue(':bairro', $bairro);
				$insere_dados->bindValue(':endereco', $endereco);
				$insere_dados->bindValue(':numero', $numero);
				// Executa a operacao
				$insere_dados->execute();
				// Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_select_fornecedor.php/#nome');
				die;
			// Se a insercao nao for possivel de realizar
			} catch (PDOException $falha_insercao) {
			    $msg = "A inserção não foi feita".$falha_insercao->getMessage();
				header('Location: /web/form_crud/form_insert_fornecedor.php?error='.$msg);
			    die;
			} catch (Exception $falha) {
				$msg = "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_insert_fornecedor.php?error='.$msg);
				die;
			}
		// Caso nao exista
		} else {
			$msg = "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_insert_fornecedor.php?error='.$msg);
			exit;
		} 	
	?>
</body>
</html>