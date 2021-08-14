<?php
	// Arquivo conexao.php
	require_once '../conexao/conexao.php';
	
	// Variavel $cd_venda que recebe a coluna cd_venda da tabela produto_venda
	$cd_produto_venda = $_POST["cd_produto_venda"];  // Importante ser $_GET para a requisicao funcionar
	// Se a selecao for possivel de realizar

	try {

		$conexao->beginTransaction();

		$procurar_produto = "SELECT * FROM produtos_venda WHERE cd_produto_venda = :cd_produto_venda";
		$busca_registro = $conexao->prepare($procurar_produto);
		$busca_registro->bindValue(':cd_produto_venda', $cd_produto_venda);
		$busca_registro->execute();
		$linha = $busca_registro->fetch(PDO::FETCH_ASSOC);

		$query = "UPDATE compra_produto SET quantidade = quantidade + :qtd WHERE cd_produto = :cd_produto";
		$atualizar_produto = $conexao->prepare($query);
		$atualizar_produto->bindValue(':qtd', $linha['quantidade']);
		$atualizar_produto->bindValue(':cd_produto', $linha['cd_produto']);
		$atualizar_produto->execute();
		
		
		// Query que faz a selecao do cd_produto
		$selecao = "DELETE FROM produtos_venda WHERE cd_produto_venda = :cd_produto_venda";
		// $seleciona_dados recebe $conexao que prepare a operacao para selecionar
		$seleciona_dados = $conexao->prepare($selecao);
		// Vincula um valor a um paramentro
		$seleciona_dados->bindValue(':cd_produto_venda', $cd_produto_venda, PDO::PARAM_INT);
		// Executa a operacao
		$seleciona_dados->execute();
		// Retorna uma matriz contendo todas as linhas do conjunto de resultados

		$conexao->commit();
		if ($seleciona_dados->rowCount() > 0){

			echo json_encode(['success'=>true]);
		}else{
			echo json_encode(['success'=>false]);
		}
		
		// Funcao que converte um array PHP em dados para JSON 
	// Se a selecao nao for possivel de realizar
	} catch (PDOException $falha_selecao) {
		$conexao->rollBack();
		echo json_encode(['success'=>false]);
	} catch (Exception $falha) {
		$conexao->rollBack();
		echo json_encode(['success'=>false]);
	}
?>