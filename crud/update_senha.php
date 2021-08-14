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
	<title> UPDATE | SENHA </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Atualizar
		if(isset($_POST['Atualizar'])){
			// Especifica a variavel 
			$cd_funcionario = $_POST['cd_funcionario'];
			$senha_atual = $_POST['senha']; 
			$senha_nova = $_POST['senha_nova'];
			$confirmar_senha_nova = $_POST['confirmar_senha_nova'];
			// Query que seleciona chave e nome do funcionario
			$selecao = $conexao->prepare("SELECT * FROM funcionario WHERE cd_funcionario = :cd_funcionario LIMIT 1");
			// Especifica a variavel
			$selecao->bindValue(":cd_funcionario", $cd_funcionario);
			// Executa a operacao
			$selecao->execute();
			// Retorna uma matriz contendo todas as linhas do conjunto de resultados
			$linhas = $selecao->fetch(PDO::FETCH_ASSOC);
			// Query que recebe a matriz das senhas			
			$senha_mysql = $linhas['senha'];
			$usuario_nome = $linhas['nome'];
			// Se a atualizacao da senha for possivel de realizar
			try {
				// Se a $senha_atual for diferente de $senha_mysql ou a $senha_nova for diferente de $confirmar_senha
				if (!password_verify($senha_atual, $senha_mysql) || ($senha_nova != $confirmar_senha_nova)){
					// Mensagem
					$msg = "{$usuario_nome}, algo deu errado na atualização de sua senha, refaça novamente a operação.";					
					header('Location: /web/form_crud/form_update_senha.php?error='.$msg);
					die;
				// Se a nova senha for igual a senha armazenada no BD
				} elseif (password_verify($senha_nova, $senha_mysql)) {
					$msg = "{$usuario_nome}, sua nova senha é idêntica a sua antiga senha, refaça novamente a operação.";
					header('Location: /web/form_crud/form_update_senha.php?error='.$msg);
					die;
				// A senha vai ser alterada
				} else {
                    // Cria uma senha com password_hash onde seu comprimento muda de acordo com o tempo
					$confirmar_senha_nova = password_hash($confirmar_senha_nova, PASSWORD_DEFAULT);
					// $update realiza a operacao de atualizar a senha do funcionario
					$update = $conexao->prepare("UPDATE funcionario SET senha = :nova_senha WHERE cd_funcionario = :cd_funcionario");
                    // Vincula o valor a um parametro
					$update->bindValue(":nova_senha", $confirmar_senha_nova);
					$update->bindValue(":cd_funcionario", $cd_funcionario);
					// Executa a operacao
					$update->execute();
					// Mensagem
					$msg = "{$usuario_nome}, sua senha foi atualizada com sucesso!";
					header('Location: /web/form_crud/form_update_senha.php?error='.$msg);
					die;
				}
			// Se a atualizacao da senha nao for possivel de realizar	
			} catch (PDOException $falha_alteracao) {
				$msg = "A alteração da senha não foi feita".$falha_alteracao->getMessage();
				header('Location: /web/form_crud/form_update_senha.php?error='.$msg);
				die;
			} catch (Exception $falha) {
				$msg = "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_update_senha.php?error='.$msg);
				die;
			}
		// Caso nao exista	
		} else {
			$msg = "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_update_senha.php?error='.$msg);
			exit;
		}
	?>
</body>
</html>