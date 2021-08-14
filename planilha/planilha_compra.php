<?php
	// Arquivo conexao.php
	require_once '../conexao/conexao.php'; 
	// Arquivo classe_usuario.php
	require_once '../classe/classe_usuario.php';
	// Inicio da sessao
	session_start();
	// Se existir $_SESSION['id_usuario'] e nao for vazio
	if((isset($_SESSION['id_usuario'])) && (!empty($_SESSION['id_usuario']))){
		echo "";
	// Se nao
	} else {
		// Retorna para a pagina index.php
		echo "<script> alert('Ação inválida, entre no sistema da maneira correta.'); location.href='/web/index.php' </script>";
		die;
	}
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
?>

<?php

	$qnt_registro = "SELECT COUNT(*) FROM compra_produto
	INNER JOIN fornecedor ON (fornecedor.cd_fornecedor = compra_produto.cd_fornecedor)";
	$seleciona_qnt = $conexao->prepare($qnt_registro);
	$seleciona_qnt->execute();
	$linha_qnt = $seleciona_qnt->fetchColumn();

	if ($linha_qnt <= 0) {
		echo "<script> alert('Não existem registros de compras para gerar uma planilha.'); window.close(); </script>";
		die;
	}

	// Se a selecao for possivel de realizar
	try {
		// Query que armazena INNER JOIN
		$registros_compra = "SELECT compra_produto.cd_produto, 
		fornecedor.nome AS fornecedor_nome, fornecedor.cnpj AS cnpj_fornecedor,
		compra_produto.nome AS produto_nome, compra_produto.marca, compra_produto.codigo_barra, 
		compra_produto.cor, compra_produto.tamanho, compra_produto.genero, compra_produto.quantidade, 
		compra_produto.valor_compra, compra_produto.porcentagem_revenda, 
		compra_produto.valor_revenda, compra_produto.data_compra FROM compra_produto
		INNER JOIN fornecedor ON (fornecedor.cd_fornecedor = compra_produto.cd_fornecedor);";
		// $seleciona_dados recebe $conexao que prepare a operacao para selecionar
		$seleciona_dados = $conexao->prepare($registros_compra);
		// Executa a operacao
		$seleciona_dados->execute();
		// Retorna uma matriz contendo todas as linhas do conjunto de resultados
		$linhas = $seleciona_dados->fetchAll(PDO::FETCH_ASSOC);
		// Se a selecao nao for possivel de realizar
	} catch (PDOException $falha_selecao) {
		echo "O relatório de itens compra não pode ser gerado".$falha_selecao->getMessage();
		die;
	} catch (Exception $falha) {
		echo "Erro não característico do PDO".$falha->getMessage();
		die;
	}

	$arqExcel = "<meta charset='UTF-8'>";

	$arqExcel .=
		"<table border='1'>
				<caption> Relatório de compra</caption>
				<thead>
					<tr> 
						<th> ID </th> 
						<th> Fornecedor </th>
						<th> CNPJ </th>  
						<th> Produto </th> 
						<th> Marca </th> 
						<th> Código de barra </th> 
						<th> Cor </th> 
						<th> Tamanho </th> 
						<th> Gênero </th> 
						<th> Quantidade </th> 
						<th> Valor da compra </th>
						<th> Porcentagem de revenda </th> 
						<th> Valor de revenda </th>  
						<th> Data da compra </th> 
					</tr>
				</thead>
					<tbody>";
	foreach ($linhas as $exibir_registros) {
		$arqExcel .= "
							<tr>
					 			<td align='center'>{$exibir_registros['cd_produto']}</td>
					 			<td align='center'>{$exibir_registros['fornecedor_nome']}</td>
					 			<td align='center'>{$exibir_registros['cnpj_fornecedor']}</td>
					 			<td align='center'>{$exibir_registros['produto_nome']}</td>
					 			<td align='center'>{$exibir_registros['marca']}</td>
					 			<td align='center'>{$exibir_registros['codigo_barra']}</td>
					 			<td align='center'>{$exibir_registros['cor']}</td>
					 			<td align='center'>{$exibir_registros['tamanho']}</td>
					 			<td align='center'>{$exibir_registros['genero']}</td>
					 			<td align='center'>{$exibir_registros['quantidade']}</td>
					 			<td align='center'>R$ {$exibir_registros['valor_compra']}</td>
					 			<td align='center'>{$exibir_registros['porcentagem_revenda']}%</td>
					 			<td align='center'>R$ {$exibir_registros['valor_revenda']}</td>
					 			<td align='center'>" . date('d/m/Y H:i:s', strtotime($exibir_registros['data_compra'])) . "</td>
					 		</tr>";
	}
	$arqExcel .= " 
					</tbody>
		</table>";
	header("Content-Type: application/x-msexcel");
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header('Content-Disposition: attachment; filename="relatorio_compra.xls"');
	echo $arqExcel;
?>