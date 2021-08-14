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
	<title> DELETE | DEVOLUÇÃO </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Deletar
		if(isset($_POST['Deletar'])){
			// Especifica a variavel
			$cd_devolucao = $_POST['cd_devolucao'];
			// Se a remocao for possivel de realizar
			try {
				// Metodo que inicializa a(s) transacao(oes)
				$conexao->beginTransaction();
            	// Busca registro da tabela venda
				$procurar_produto = "SELECT produtos_venda.cd_produto, produtos_devolucao.quantidade FROM produtos_devolucao INNER JOIN produtos_venda ON produtos_venda.cd_produto_venda = produtos_devolucao.cd_produto_venda WHERE cd_devolucao = :cd_devolucao";
            	// $busca_registro recebe $procurar_produto que prepara a selecao do registro
				$busca_registro = $conexao->prepare($procurar_produto);
            	// Vincula um valor a um parametro
				$busca_registro->bindValue(':cd_devolucao', $cd_devolucao);
            	// Executa a operação
				$busca_registro->execute();
				while ($linha = $busca_registro->fetch(PDO::FETCH_ASSOC)) {				
					// Variaveis a serem usadas no update da tabela produto
					$quantidade[$linha['cd_produto']] = $linha['quantidade']; 
				}
			    // Query que faz a remocao
			    $remove = "DELETE FROM devolucao WHERE cd_devolucao = :cd_devolucao";
			    // $remocao recebe $conexao que prepare a operacao de exclusao
			    $remocao = $conexao->prepare($remove);
			    // Recebendo referencias e valores como argumento
			    $remocao->bindValue(':cd_devolucao', $cd_devolucao);
			    // Executa a operacao
			    $remocao->execute();
				$remove = "DELETE FROM produtos_devolucao WHERE cd_devolucao = :cd_devolucao";
			    // $remocao recebe $conexao que prepare a operacao de exclusao
				$remocao = $conexao->prepare($remove);
			    // Vincula um valor a um parametro
				$remocao->bindValue(':cd_devolucao', $cd_devolucao);
			    // Executa a operacao
				$remocao->execute();
				// TABELA PRODUTO
			    // Query que faz a atualizacao da quantidade de estoque da tabela produto
				foreach ($quantidade as $cd_produto => $qtd) {
					$atualiza_quantidade = "UPDATE compra_produto SET quantidade = quantidade - :quantidade 
					WHERE cd_produto = :cd_produto";
					// $quantidade_produto recebe $conexao que prepara a transacao para atualiza o estoque na tabela produto
					$quantidade_produto = $conexao->prepare($atualiza_quantidade);
					$quantidade_produto->bindValue(':quantidade', $qtd);
					$quantidade_produto->bindValue(':cd_produto', $cd_produto);
					// Executa a operacao
					$quantidade_produto->execute();
				}
        		// Confirma a execucao das query's em todas as transacoes 
				$conexao->commit();
        		// Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_select_devolucao.php/#nome');
				die;
			// Se a remocao nao for possivel de realizar
			} catch (PDOException $falha_remocao) {
			    $msg =  "A remoção não foi feita".$falha_remocao->getMessage();
				header('Location: /web/form_crud/form_delete_devolucao.php?id='.$cd_funcionario.'&error='.$msg);

			    die;
			} catch (Exception $falha) {
				$msg = "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_delete_devolucao.php?id='.$cd_funcionario.'&error='.$msg);
				die;
			}
		// Caso nao exista
		} else {
			$msg = "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_delete_devolucao.php?id='.$cd_funcionario.'&error='.$msg);
			exit;
		} 	
	?>
</body>
</html>