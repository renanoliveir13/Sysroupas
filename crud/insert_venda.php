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
	<title> INSERT | VENDA </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php  
	
		// Se existir o botao de Inserir
		if (isset($_POST['Inserir'])) {
			try {				
				$_SESSION['form_venda'] = json_encode($_POST);
				// Cria a venda
				// Método que inicializa a(s) transacao(oes)
				$conexao->beginTransaction();
				
				// Query que faz a insercao	
				$insercao = "INSERT INTO venda (cd_funcionario,cd_cliente) 
				VALUES (:cd_funcionario,:cd_cliente)";
				// $atualiza_dados recebe $conexao que prepare a operacao de insercao
				$insere_dados = $conexao->prepare($insercao);
				// Vincula um valor a um parametro
				$insere_dados->bindValue(':cd_funcionario', $_POST['cd_funcionario']);
				$insere_dados->bindValue(':cd_cliente', $_POST['cd_cliente']);
				// Executa a operacao
				$insere_dados->execute();

				
				$cd_venda = $conexao->lastInsertId();
				
				foreach ($_POST['cd_produto'] as $i => $cd_produto) {
					// Especifica a variavel					
					
					$quantidade = $_POST['quantidade'][$i];					
					

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
					$insercao = "INSERT INTO produtos_venda (cd_venda,cd_produto,valor_item,quantidade,valor_venda) 
					VALUES (:cd_venda,:cd_produto,:valor_item,:quantidade,:valor_venda)";
					// $atualiza_dados recebe $conexao que prepare a operacao de insercao
					$insere_dados = $conexao->prepare($insercao);
					// Vincula um valor a um parametro
					$insere_dados->bindValue(':cd_venda', $cd_venda);
					$insere_dados->bindValue(':cd_produto', $cd_produto);
					$insere_dados->bindValue(':valor_item', $produto['valor_revenda']);
					$insere_dados->bindValue(':quantidade', $quantidade);
					$insere_dados->bindValue(':valor_venda', ($quantidade * $produto['valor_revenda']));
					// Executa a operacao
					$insere_dados->execute();
										
					// Tabela PRODUTO
					if ($quantidade <= $quantidade_antiga) {
						// Havera retirada de produto (caso a nova quantidade seja menor que a antiga)
						$calculo_reposicao = "UPDATE compra_produto SET quantidade = ('$quantidade_antiga'-:quantidade) 
						WHERE cd_produto = :cd_produto";
					// Caso a quantidade vendida seja maior que a quantidade em estoque
					} elseif ($quantidade > $quantidade_antiga) {
						$conexao->rollBack();
						// $msg = "A quantidade de produtos vendidos não pode ultrapassar a quantidade em estoque, refaça novamente a operação.";
						// header('Location: /web/form_crud/form_insert_venda.php?error='.$msg);
						$msg = "Quantidade insuficiente no estoque para <b>{$_POST['produto'][$i]}</b>, estoque atual de <b>$quantidade_antiga</b>, refaça a operação.";
						header('Location: /web/form_crud/form_insert_venda.php?error=' . $msg);
						exit;
					}
					// $quantidade_estoque recebe $conexao que prepara a transacao para atualiza o estoque na tabela produto
					$quantidade_estoque = $conexao->prepare($calculo_reposicao);
					// Vincula um valor a um parametro da tabela produto
					$quantidade_estoque->bindValue(':cd_produto', $cd_produto);
					$quantidade_estoque->bindValue(':quantidade', $quantidade);
					// Executa a operacao
					$quantidade_estoque->execute();
				}
				// Confirma a execucao das query's em todas as transacoes  
				$conexao->commit();
				unset($_SESSION['form_venda']);
				// Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_select_venda.php/#nome');			
			// Se a insercao nao for possivel de realizar
			} catch (PDOException $falha_insercao) {
				$conexao->rollBack();
				$msg = "A insercão não foi feita".$falha_insercao->getMessage();
				header('Location: /web/form_crud/form_insert_venda.php?error='.$msg);
				die;
			} catch (Exception $falha) {
				$conexao->rollBack();
				$msg = "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_insert_venda.php?error='.$msg);
				die;
			}
			
		// Caso nao exista
		} else {
			$msg = "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_insert_venda.php?error='.$msg);
			exit;
		} 
	?>
</body>
</html>