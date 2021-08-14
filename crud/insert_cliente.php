<?php
	// Arquivo conexao.php
	require_once '../conexao/conexao.php'; 
	// Arquivo classe_usuario.php
	require_once '../classe/classe_usuario.php';
	
	// Verifica usuário logado
	$u = new Usuario();
	$u->Verificar();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> INSERT | CLIENTE </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Inserir
		if(isset($_POST['Inserir'])){
			// Especifica a variavel
			$nome = $_POST['nome'];
			$cpf = $_POST['cpf']; // Constraint UNIQUE no BD
			$telefone = $_POST['telefone']; // Constraint UNIQUE no BD
			$email = $_POST['email']; // Constraint UNIQUE no BD
			$cidade = $_POST['cidade'];
			$bairro = $_POST['bairro'];
			$rua = $_POST['rua'];
			$numero = $_POST['numero'];

			// Query que verifica se existe cpf, telefone e email iguais de clientes
			$procurar_cliente = "SELECT COUNT(*) FROM cliente WHERE cpf = :cpf OR telefone = :telefone OR email = :email LIMIT 1";
			$busca_cliente = $conexao->prepare($procurar_cliente);
			$busca_cliente->bindValue(':cpf',$cpf);
			$busca_cliente->bindValue(':telefone',$telefone);
			$busca_cliente->bindValue(':email',$email);
			$busca_cliente->execute();
			$existe = $busca_cliente->fetchColumn();
			// Se existe cpf, telefone e email iguais de clientes
			if ($existe != 0) {
				$msg =  "Alguma informação de CPF, telefone ou e-mail pertence a outro cliente cadastrado, refaça a operação de inserção.";
				header('Location: /web/form_crud/form_insert_cliente.php?error='.$msg);
				exit;
			}

			// Se a insercao for possivel de realizar
			try {
				// Query que faz a insercao	
				$insercao = "INSERT INTO cliente (nome,cpf,telefone,email,cidade,bairro,rua,numero)
				VALUES (:nome,:cpf,:telefone,:email,:cidade,:bairro,:rua,:numero)";
				// $insere_dados recebe $conexao que prepare a operacao de insercao
				$insere_dados = $conexao->prepare($insercao);
				// Vincula um valor a um parametro
				$insere_dados->bindValue(':nome', $nome);
				$insere_dados->bindValue(':cpf', $cpf);
				$insere_dados->bindValue(':telefone', $telefone);
				$insere_dados->bindValue(':email', $email);
				$insere_dados->bindValue(':cidade', $cidade);
				$insere_dados->bindValue(':bairro', $bairro);
				$insere_dados->bindValue(':rua', $rua);
				$insere_dados->bindValue(':numero', $numero);
				// Executa a operacao
				$insere_dados->execute();
				// Retorna para a pagina de formulario de listagem
				header('Location: /web/form_crud/form_select_cliente.php/#nome');
				die;
			// Se a insercao nao for possível de realizar
			} catch (PDOException $falha_insercao) {
				$msg =  "A inserção não foi feita".$falha_insercao->getMessage();
				header('Location: /web/form_crud/form_insert_cliente.php?error='.$msg);
				die;
			} catch (Exception $falha) {
				$msg = "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_insert_cliente.php?error='.$msg);
				die;
			}
		// Caso nao exista
		} else {
			$msg =  "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_insert_cliente.php?error='.$msg);
			exit;
		} 		
	?>
</body>
</html>