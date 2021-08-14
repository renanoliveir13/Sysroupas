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
	<title> UPDATE | VENDA </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>

<body>
	<?php
	// Se existir o botao de Atualizar
	if (isset($_POST['Atualizar'])) {

		try {
			
			$cd_venda = $_POST['cd_venda'];
			$cd_cliente = $_POST['cd_cliente'];

			$conexao->beginTransaction();
			foreach ($_POST['cd_produto'] as $i => $cd_produto) {
				// Especifica a variavel					
				if ($cd_produto[$i] == 0) {
					$quantidade = $_POST['quantidade'][$i];


					// Se a quantidade ou valor do item for menor/igual a zero
					if ($quantidade <= 0) {
						//Rollback para Desfazer as alterações no banco de dados//
						$conexao->rollBack();
						$msg = $_POST['produto'][$i]." foi informado com quantidade 0, refaça novamente a operação.";
						header('Location: /web/form_crud/form_update_venda.php?id=' . $cd_venda . '&error=' . $msg);
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
					$quantidade_estoque = $produto['quantidade'];

					if ($quantidade > $quantidade_estoque ){
						//Rollback para Desfazer as alterações no banco de dados//
						$conexao->rollBack();
						$msg = "Quantidade insuficiente no estoque para <b>{$_POST['produto'][$i]}</b>, estoque atual de <b>$quantidade_estoque</b>, refaça a operação.";
						header('Location: /web/form_crud/form_update_venda.php?id=' . $cd_venda . '&error=' . $msg);
						exit;
					}

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


					$calculo_reposicao = "UPDATE compra_produto SET quantidade = quantidade-:quantidade
					WHERE cd_produto = :cd_produto";
					// $quantidade_estoque recebe $conexao que prepara a transacao para atualiza o estoque na tabela produto
					$quantidade_estoque = $conexao->prepare($calculo_reposicao);
					// Vincula um valor a um parametro da tabela produto
					$quantidade_estoque->bindValue(':cd_produto', $cd_produto);
					$quantidade_estoque->bindValue(':quantidade', $quantidade);
					// Executa a operacao
					$quantidade_estoque->execute();
				}
			}

			// Confirma a execucao das query's em todas as transacoes  
			$conexao->commit();
			// Retorna para a pagina de formulario de listagem
			header('Location: ../form_crud/form_select_venda.php/#nome');
			die;
			// Se a atualizacao nao for possivel de realizar
		} catch (PDOException $falha_atualizacao) {
			$conexao->rollBack();
			echo "A atualização não foi feita" . $falha_atualizacao->getMessage();
			die;
		} catch (Exception $falha) {
			$conexao->rollBack();
			echo "Erro não característico do PDO" . $falha->getMessage();
			die;
		}
		// Caso nao exista
	} else {
		echo "Ocorreu algum erro, refaça novamente a operação.";
		echo '<p><a href="../form_crud/form_update_venda.php/#atu_ven" 
			title="Refazer operação"><button>Botão refazer operação</button></a></p>';
		exit;
	}
	?>
</body>

</html>