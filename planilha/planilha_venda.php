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

	$qnt_registro = "SELECT COUNT(*) FROM venda
	INNER JOIN produtos_venda ON (produtos_venda.cd_venda = venda.cd_venda)
    INNER JOIN compra_produto ON (compra_produto.cd_produto = produtos_venda.cd_produto)
    INNER JOIN funcionario ON (funcionario.cd_funcionario = venda.cd_funcionario)
    INNER JOIN cliente ON (cliente.cd_cliente = venda.cd_cliente)";
    $seleciona_qnt = $conexao->prepare($qnt_registro);
    $seleciona_qnt->execute();
    $linha_qnt = $seleciona_qnt->fetchColumn();

    if ($linha_qnt <= 0) {
        echo "<script> alert('Não existem registros de vendas para gerar uma planilha.'); window.close(); </script>";
        die;
    }

	// Se a selecao for possivel de realizar
	try {
		// Query que armazena INNER JOIN
		$registros_venda = "SELECT venda.cd_venda, compra_produto.nome AS nome_produto, 
		compra_produto.marca, compra_produto.codigo_barra, compra_produto.cor, 
		compra_produto.tamanho, compra_produto.genero, venda.tipo_pagamento, 
		produtos_venda.valor_item, produtos_venda.quantidade, produtos_venda.valor_venda, 
		funcionario.nome AS nome_funcionario, cliente.nome AS nome_cliente, 
		cliente.cpf AS cpf_cliente,venda.data_venda FROM produtos_venda
			INNER JOIN venda ON (venda.cd_venda = produtos_venda.cd_venda)
			INNER JOIN compra_produto ON (compra_produto.cd_produto = produtos_venda.cd_produto)
			INNER JOIN cliente ON (cliente.cd_cliente = venda.cd_cliente)
			INNER JOIN funcionario ON (funcionario.cd_funcionario = venda.cd_funcionario)";
		// $seleciona_dados recebe $conexao que prepare a operacao para selecionar
		$seleciona_dados = $conexao->prepare($registros_venda);
		// Executa a operacao
		$seleciona_dados->execute();
		// Retorna uma matriz contendo todas as linhas do conjunto de resultados
		$linhas = $seleciona_dados->fetchAll(PDO::FETCH_ASSOC);
		// Se a seleção não for possível de realizar
	} catch (PDOException $falha_selecao) {
		echo "O relatório de vendas não pode ser gerado".$falha_selecao->getMessage();
		die;
	} catch (Exception $falha) {
		echo "Erro não característico do PDO".$falha->getMessage();
		die;
	}

	$arqExcel = "<meta charset='UTF-8'>";

	$arqExcel .=
		"<table border='1'>
				<caption> Relatório de vendas </caption>
				<thead>
					<tr> 
						<th> ID </th> 
						<th> Produto </th> 
						<th> Marca </th> 
						<th> Código de barra </th> 
						<th> Cor </th> 
						<th> Tamanho </th> 
						<th> Gênero </th>
						<th> Valor do item </th>    
						<th> Quantidade </th> 
						<th> Valor da venda </th>
						<th> Tipo de pagamento </th>
						<th> Funcionário </th>
						<th> Cliente </th>
						<th> CPF do cliente </th>  
						<th> Data da venda </th> 
					</tr>
				</thead>
					<tbody>";
	foreach ($linhas as $exibir_registros) {
		$arqExcel .= "
							<tr>
					 			<td align='center'>{$exibir_registros['cd_venda']}</td>
					 			<td align='center'>{$exibir_registros['nome_produto']}</td>
					 			<td align='center'>{$exibir_registros['marca']}</td>
					 			<td align='center'>{$exibir_registros['codigo_barra']}</td>
					 			<td align='center'>{$exibir_registros['cor']}</td>
					 			<td align='center'>{$exibir_registros['tamanho']}</td>
					 			<td align='center'>{$exibir_registros['genero']}</td>	
					 			<td align='center'>R$ {$exibir_registros['valor_item']}</td>
					 			<td align='center'>{$exibir_registros['quantidade']}</td>
					 			<td align='center'>R$ {$exibir_registros['valor_venda']}</td>
					 			<td align='center'>{$exibir_registros['tipo_pagamento']}</td>
					 			<td align='center'>{$exibir_registros['nome_funcionario']}</td>
					 			<td align='center'>{$exibir_registros['nome_cliente']}</td>
					 			<td align='center'>{$exibir_registros['cpf_cliente']}</td>
					 			<td align='center'>" . date('d/m/Y H:i:s', strtotime($exibir_registros['data_venda'])) . "</td>
					 		</tr>";
	}
	$arqExcel .= " 
					</tbody>
		</table>";
	header("Content-Type: application/x-msexcel");
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header('Content-Disposition: attachment; filename="relatorio_venda.xls"');
	echo $arqExcel;
?>