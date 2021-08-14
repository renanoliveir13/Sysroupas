<?php
	// Arquivo conexao.php
	require_once '../conexao/conexao.php';
	// Variavel $cd_venda que recebe a coluna cd_venda da tabela produto_venda
	$cd_produto_venda = $_GET["cd_produto_venda"];  // Importante ser $_GET para a requisicao funcionar
	// Se a selecao for possivel de realizar
	try {
		// Query que faz a selecao do cd_produto
		$selecao = "SELECT compra_produto.quantidade quantidade_estoque, produtos_venda.quantidade, produtos_venda.valor_item FROM compra_produto INNER JOIN produtos_venda ON compra_produto.cd_produto = produtos_venda.cd_produto WHERE produtos_venda.cd_produto_venda = :cd_produto_venda";
		// $seleciona_dados recebe $conexao que prepare a operacao para selecionar
		$seleciona_dados = $conexao->prepare($selecao);
		// Vincula um valor a um paramentro
		$seleciona_dados->bindValue(':cd_produto_venda', $cd_produto_venda, PDO::PARAM_INT);
		// Executa a operacao
		$seleciona_dados->execute();
		// Retorna uma matriz contendo todas as linhas do conjunto de resultados
		$linhas = $seleciona_dados->fetchAll(PDO::FETCH_ASSOC);
		// Funcao que converte um array PHP em dados para JSON 
		echo json_encode($linhas);
	// Se a selecao nao for possivel de realizar
	} catch (PDOException $falha_selecao) {
		echo "A listagem de dados não foi feita".$falha_selecao->getMessage();
	} catch (Exception $falha) {
		echo "Erro não característico do PDO".$falha->getMessage();
	}
?>