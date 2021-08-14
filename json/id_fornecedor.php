<?php
	// Arquivo conexao.php
	require_once '../conexao/conexao.php';
	// Variavel $cd_fornecedor que recebe a coluna cd_fornecedor da tabela fornecedor
	$cd_fornecedor = $_GET["cd_fornecedor"];  // Importante ser $_GET para a requisição funcionar
	// Se a selecao for possivel de realizar
	try {
		// Query que faz a selecao do cd_fornecedor
		$selecao = "SELECT * FROM fornecedor WHERE cd_fornecedor = :cd_fornecedor LIMIT 1";
		// $seleciona_dados recebe $conexao que prepare a operacao para selecionar
		$seleciona_dados = $conexao->prepare($selecao);
		// Vincula um valor a um paramentro
		$seleciona_dados->bindValue(':cd_fornecedor', $cd_fornecedor, PDO::PARAM_INT);
		// Executa a operacao
		$seleciona_dados->execute();
		// Retorna uma matriz contendo todas as linhas do conjunto de resultados
		$linhas = $seleciona_dados->fetchAll(PDO::FETCH_ASSOC);
		// Funcao que converte um array PHP em dados para JSON 
		echo json_encode($linhas);
	// Se a selecao nao for possível de realizar
	} catch (PDOException $falha_selecao) {
		echo "A listagem de dados não foi feita".$falha_selecao->getMessage();
	} catch (Exception $falha) {
		echo "Erro não característico do PDO".$falha->getMessage();
	}
?>