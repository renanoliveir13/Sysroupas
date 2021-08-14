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
	<title> INSERT | ENTRADA </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php  

		// Se existir o botao de Inserir
		if (isset($_POST['Inserir'])) {
			try {				
				// Cria a venda
				// Método que inicializa a(s) transacao(oes)
				$conexao->beginTransaction();
				
				// Query que faz a insercao	
				$insercao = "INSERT INTO entrada (cd_funcionario,cd_fornecedor,descricao) 
				VALUES (:cd_funcionario,:cd_fornecedor, :descricao)";
				// $atualiza_dados recebe $conexao que prepare a operacao de insercao
				$insere_dados = $conexao->prepare($insercao);
				// Vincula um valor a um parametro
				$insere_dados->bindValue(':descricao', $_POST['descricao']);
				$insere_dados->bindValue(':cd_funcionario', $_POST['cd_funcionario']);
				$insere_dados->bindValue(':cd_fornecedor', $_POST['cd_fornecedor']);
				// Executa a operacao
				$insere_dados->execute();

				
				$cd_entrada = $conexao->lastInsertId();
				
				foreach ($_POST['cd_produto'] as $i => $cd_produto) {
					// Especifica a variavel					
					
					$quantidade = $_POST['quantidade'][$i];	
					$valor_item = $_POST['valor_item'][$i];				
					$porcentagem_revenda = $_POST['pct_revenda'][$i];
					$valor_revenda = ($valor_item + ($valor_item * ($porcentagem_revenda / 100)));

					// Se a quantidade ou valor do item for menor/igual a zero
					if ($quantidade <= 0) {
						//Rollback para Desfazer as alterações no banco de dados//
						$conexao->rollBack();
						$msg = "A quantidade ou valor do produto não pode ser igual ou menor que zero, refaça novamente a operação.";
						header('Location: /web/form_crud/form_insert_venda.php?error='.$msg);
						exit;
					}

					// Tabela PRODUTO
					// Query que busca a quantidade de um registro da tabela produto
					$procurar_produto = "SELECT * FROM compra_produto WHERE cd_produto = :cd_produto LIMIT 1";
					$busca_registro = $conexao->prepare($procurar_produto);
					$busca_registro->bindValue(':cd_produto', $cd_produto);
					$busca_registro->execute();
					$produto = $busca_registro->fetch(PDO::FETCH_ASSOC);
					// Vincula um valor a um parametro das colunas da tabela venda
					$quantidade_antiga = $produto['quantidade'];

					// Query que faz a insercao	
					$insercao = "INSERT INTO produtos_entrada (cd_entrada,cd_produto,quantidade, valor_item, porcentagem_revenda) 
					VALUES (:cd_entrada,:cd_produto,:quantidade, :valor_item, :pct)";
					// $atualiza_dados recebe $conexao que prepare a operacao de insercao
					$insere_dados = $conexao->prepare($insercao);
					// Vincula um valor a um parametro
					$insere_dados->bindValue(':cd_entrada', $cd_entrada);
					$insere_dados->bindValue(':cd_produto', $cd_produto);
					$insere_dados->bindValue(':quantidade', $quantidade);
					$insere_dados->bindValue(':valor_item', $valor_item);
					$insere_dados->bindValue(':pct', $porcentagem_revenda);
					// Executa a operacao
					$insere_dados->execute();
										
					// Havera retirada de produto (caso a nova quantidade seja menor que a antiga)
					$calculo_reposicao = "UPDATE compra_produto SET quantidade = quantidade + :quantidade, valor_compra = :valor_compra,
					porcentagem_revenda = :porcentagem_revenda, valor_revenda = :valor_revenda
					WHERE cd_produto = :cd_produto";
					// $quantidade_estoque recebe $conexao que prepara a transacao para atualiza o estoque na tabela produto
					$quantidade_estoque = $conexao->prepare($calculo_reposicao);
					// Vincula um valor a um parametro da tabela produto
					$quantidade_estoque->bindValue(':cd_produto', $cd_produto);
					$quantidade_estoque->bindValue(':quantidade', $quantidade);
					$quantidade_estoque->bindValue(':valor_compra', $valor_item);
					$quantidade_estoque->bindValue(':porcentagem_revenda', $porcentagem_revenda);
					$quantidade_estoque->bindValue(':valor_revenda', $valor_revenda);
					// Executa a operacao
					$quantidade_estoque->execute();
				}
				// Confirma a execucao das query's em todas as transacoes  
				$conexao->commit();
				// Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_select_notaentrada.php/#nome');			
			// Se a insercao nao for possivel de realizar
			} catch (PDOException $falha_insercao) {
				$conexao->rollBack();				
				$msg = "A insercão não foi feita";
				header('Location: /web/form_crud/form_insert_notaentrada.php?error='.$msg);
				die;
			} catch (Exception $falha) {
				$conexao->rollBack();
				$msg = "Erro não característico do PDO";
				header('Location: /web/form_crud/form_insert_notaentrada.php?error='.$msg);
				die;
			}
			
		// Caso nao exista
		} else {
			$msg = "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_insert_notaentrada.php?error='.$msg);
			exit;
		} 
	?>
</body>
</html>