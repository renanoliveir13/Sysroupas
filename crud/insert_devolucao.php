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
	<title> INSERT | DEVOLUÇÃO </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Inserir
		if (isset($_POST['Inserir'])) {			

			// Se a atualizacao for possível de realizar
			try {

				// Metodo que inicializa a(s) transação(oes)
				$conexao->beginTransaction();
				// Query que faz a insercao	
				$insercao = "INSERT INTO devolucao (cd_devolucao) VALUES (NULL)";
				// $atualiza_dados recebe $conexao que prepara a operacao de inserção
				$insere_dados = $conexao->prepare($insercao);
				// Executa a operacao
				$insere_dados->execute();

				$procurar_cd = "SELECT cd_devolucao FROM devolucao ORDER BY cd_devolucao DESC LIMIT 1";
				$busca_cd = $conexao->prepare($procurar_cd);
				$busca_cd->execute();
				$linha = $busca_cd->fetch(PDO::FETCH_ASSOC);
				$cd_devolucao = $linha['cd_devolucao'];
				
				foreach ($_POST['cd_produto'] as $i => $cd_produto) {
					// Especifica a variavel
					$cd_venda = $_POST['cd_venda'][$i];
					$cd_produto_venda = $_POST['cd_produto_venda'][$i];
					$cd_produto = $_POST['cd_produto'][$i];
					$valor_item = $_POST['valor_item'][$i];
					$quantidade = $_POST['quantidade'][$i];
					$motivo_devolucao = $_POST['motivo_devolucao'][$i];
					$valor_devolucao = ($valor_item * $quantidade);
					$quantidade_antiga = $calculo_reposicao = $reposicao_produto = 0;

					// Se a quantidade ou valor do item for menor/igual a zero
					if ($quantidade <= 0 || $valor_item <= 0) { 
						$msg = "A quantidade ou valor do produto não pode ser igual ou menor que zero, refaça novamente a operação.";
						header('Location: /web/form_crud/form_insert_devolucao.php?&error='.$msg);
						exit;
					}
						// Tabela VENDA
						// Query que busca o a quantidade de um registro da tabela venda
						$procurar_venda = "SELECT cd_produto, quantidade FROM produtos_venda WHERE cd_produto_venda = :cd_produto_venda";
						$busca_registro = $conexao->prepare($procurar_venda);
						$busca_registro->bindValue(':cd_produto_venda', $cd_produto_venda);
						$busca_registro->execute();
						$linha = $busca_registro->fetch(PDO::FETCH_ASSOC);
						// Vincula um valor a um parametro das colunas da tabela venda
						$quantidade_antiga = $linha['quantidade'];

						// Tabela VENDA
						if ($quantidade > $quantidade_antiga) {
							// Caso a quantidade devolvida seja maior que a quantidade vendida
							$msg = "A quantidade devolvida é maior que a quantidade vendida, refaça novamente a operação.";
							header('Location: /web/form_crud/form_insert_devolucao.php?&error='.$msg);
							exit;
						}

						// Havera retirada de produto (caso a nova quantidade seja menor que a antiga)
						$calculo_reposicao = "UPDATE produtos_venda SET quantidade = (:quantidade_antiga-:quantidade),
						valor_venda = (:valor_item * :quantidade) WHERE cd_produto_venda = :cd_produto_venda";
						
						$reposicao_produto = "UPDATE compra_produto SET quantidade = (quantidade+:quantidade) 
						WHERE cd_produto = :cd_produto";

						// Metodo que inicializa a(s) transação(oes)
						// Query que faz a insercao	
						$insercao = "INSERT INTO produtos_devolucao (cd_devolucao, cd_produto, cd_produto_venda,valor_item,quantidade,valor_devolucao,motivo_devolucao)
						VALUES (:cd_devolucao,:cd_produto, :cd_produto_venda,:valor_item,:quantidade,:valor_devolucao,:motivo_devolucao)";
						// $atualiza_dados recebe $conexao que prepara a operacao de inserção
						$insere_dados = $conexao->prepare($insercao);
						// Vincula um valor a um parametro
						$insere_dados->bindValue(':cd_devolucao', $cd_devolucao);
						$insere_dados->bindValue(':cd_produto_venda', $cd_produto_venda);
						$insere_dados->bindValue(':cd_produto', $cd_produto);
						$insere_dados->bindValue(':valor_item', $valor_item);
						$insere_dados->bindValue(':quantidade', $quantidade);
						$insere_dados->bindValue(':valor_devolucao', $valor_devolucao);
						$insere_dados->bindValue(':motivo_devolucao', $motivo_devolucao);
						// Executa a operacao
						$insere_dados->execute();
						
						// $quantidade_devolvida prepara a transacao para atualiza o estoque na tabela venda
						$quantidade_devolvida = $conexao->prepare($calculo_reposicao);
						// Vincula um valor a um parametro da tabela produto
						$quantidade_devolvida->bindValue(':cd_produto_venda', $cd_produto_venda);
						$quantidade_devolvida->bindValue(':quantidade_antiga', $quantidade_antiga);
						$quantidade_devolvida->bindValue(':valor_item', $valor_item);
						$quantidade_devolvida->bindValue(':quantidade', $quantidade);
						$quantidade_devolvida->execute();

						$devolver_produto = $conexao->prepare($reposicao_produto);
						$devolver_produto->bindValue(':cd_produto', $linha['cd_produto']);
						$devolver_produto->bindValue(':quantidade', $quantidade);
						$devolver_produto->execute();
						// Se a atualizacao nao for possivel de realizar
				}			
				// Confirma a execucao das query's em todas as transacoes  
				$conexao->commit();
			} catch (PDOException $falha_insercao) {
				$msg = "A insercão não foi feita".$falha_insercao->getMessage();
				header('Location: /web/form_crud/form_insert_devolucao.php?&error='.$msg);
				die;
			} catch (Exception $falha) {
				$msg = "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_insert_devolucao.php?&error='.$msg);
				die;
			}
			// Retorna para a pagina de formulario de insercao
			header('Location: ../form_crud/form_select_devolucao.php/#nome');
			die;
		// Caso nao exista
		} else {
			$msg = "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_insert_devolucao.php?&error='.$msg);
			exit;
		} 
	?>
</body>
</html>