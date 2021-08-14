<?php
	// Arquivo conexao.php
	require_once '../conexao/conexao.php'; 
	// Arquivo classe_usuario.php
	require_once '../classe/classe_usuario.php';
	// Inicio da sessao
	
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
	<title> DELETE | CLIENTE </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botão de Deletar
		if(isset($_POST['Deletar'])){
			// Especifica a variável
			$cd_cliente = $_POST['cd_cliente'];
			// Buscar nome do cliente
			$procurar_nome = "SELECT nome FROM cliente WHERE cd_cliente = :cd_cliente";
			$busca_nome = $conexao->prepare($procurar_nome);
			$busca_nome->bindValue(':cd_cliente', $cd_cliente);
			$busca_nome->execute();
			$linha_nome = $busca_nome->fetch(PDO::FETCH_ASSOC);
			$nome_cliente = $linha_nome['nome'];
			// Query que verifica se existe o registro de cliente em venda
			$procurar_cliente = "SELECT COUNT(cd_cliente) AS countCliente FROM venda WHERE cd_cliente = :cd_cliente";
			$busca_cliente = $conexao->prepare($procurar_cliente);
			$busca_cliente->bindValue(':cd_cliente',$cd_cliente);
			$busca_cliente->execute();
			$linha = $busca_cliente->fetch(PDO::FETCH_ASSOC);
			$countCliente = $linha['countCliente'];
			// Se o registro de cliente existir na tabela venda 
			if ($countCliente > 0) {
				$pluralSingular = $countCliente == 1 ? "uma venda" : "$countCliente vendas";
				$msg = "Você não pode apagar {$nome_cliente} do sistema, pois está registrado em $pluralSingular.";
				header('Location: /web/form_crud/form_delete_cliente.php?id='.$cd_cliente.'&error='.$msg);
				exit;
			}
			// Se a remoção for possível de realizar
			try {
			    // Query que faz a remoção
			    $remove = "DELETE FROM cliente WHERE cd_cliente = :cd_cliente";
			    // $remocao recebe $conexao que prepare a operação de exclusão
			    $remocao = $conexao->prepare($remove);
			    // Recebendo referencias e valores como argumento
			    $remocao->bindValue(':cd_cliente', $cd_cliente);
			    // Executa a operação
			    $remocao->execute();
			    // Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_select_cliente.php/#nome');
				die;
			// Se a remoção não for possível de realizar
			} catch (PDOException $falha_remocao) {
			    $msg = "A remoção não foi feita".$falha_remocao->getMessage();
				header('Location: /web/form_crud/form_delete_cliente.php?id='.$cd_cliente.'&error='.$msg);
			    die;
			} catch (Exception $falha) {
				$msg = "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_delete_cliente.php?id='.$cd_cliente.'&error='.$msg);
				die;
			}
		// Caso nao exista
		} else {
			$msg = "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_delete_cliente.php?id='.$cd_cliente.'&error='.$msg);
			exit;
		} 	
	?>
</body>
</html>