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
	<title> UPDATE | ENTRADA </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>

<body>
	<?php
	// Se existir o botao de Atualizar
	if (isset($_POST['Atualizar'])) {

		
		try {
			// Especifica a variavel
			$cd_entrada = $_POST['cd_entrada'];
			$cd_fornecedor = $_POST['cd_fornecedor'];
			$descricao = $_POST['descricao'];
			
			$conexao->beginTransaction();
			

			//Atualizar dados da Entrada
			$attEntrada = $conexao->prepare("UPDATE entrada SET cd_fornecedor = :cd_fornecedor, descricao = :descricao WHERE cd_entrada = :cd_entrada");			
			$attEntrada->bindValue(':cd_fornecedor', $cd_fornecedor);
			$attEntrada->bindValue(':descricao', $descricao);			
			$attEntrada->bindValue(':cd_entrada', $cd_entrada);	
			$attEntrada->execute();
			
			foreach ($_POST['cd_produto_entrada'] as $i => $cd_produto_entrada) {
				// Especifica a variavel					
				if ($cd_produto_entrada == 0) {
					$quantidade = $_POST['quantidade'][$i];
					$cd_produto = $_POST['cd_produto'][$i];
					$valor_item = $_POST['valor_item'][$i];				
					$porcentagem_revenda = $_POST['pct_revenda'][$i];
					$valor_revenda = ($valor_item + ($valor_item * ($porcentagem_revenda / 100)));

					// Se a quantidade ou valor do item for menor/igual a zero
					if ($quantidade <= 0) {
						//Rollback para Desfazer as alterações no banco de dados//
						$conexao->rollBack();
						$msg = "A quantidade ou valor do produto não pode ser igual ou menor que zero, refaça novamente a operação.";
						header('Location: /web/form_crud/form_update_notaentrada.php?id=' . $cd_entrada . '&error=' . $msg);
						exit;
					}

					// Tabela PRODUTO
					// Query que busca a quantidade de um registro da tabela produto
					$procurar_produto = "SELECT * FROM compra_produto WHERE cd_produto = :cd_produto LIMIT 1";
					$busca_registro = $conexao->prepare($procurar_produto);
					$busca_registro->bindValue(':cd_produto', $cd_produto);
					$busca_registro->execute();
					$produto = $busca_registro->fetch(PDO::FETCH_ASSOC);
					// Vincula um valor a um parametro das colunas da tabela entrada
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


					// Se a quantidade ou valor do item for menor/igual a zero
					if ($quantidade <= 0) {
						$msg = "A quantidade ou valor do produto não pode ser igual ou menor que zero, refaça novamente a operação.";
						header('Location: /web/form_crud/form_update_notaentrada.php?id=' . $cd_entrada . '&error=' . $msg);

						exit;
					}
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
			}

			// Confirma a execucao das query's em todas as transacoes  
			$conexao->commit();
			// Retorna para a pagina de formulario de listagem
			header('Location: ../form_crud/form_select_notaentrada.php/#nome');
			die;
			// Se a atualizacao nao for possivel de realizar
		} catch (PDOException $falha_atualizacao) {
			$conexao->rollBack();
			echo "A atualização não foi feita";
			die;
		} catch (Exception $falha) {
			$conexao->rollBack();
			echo "Erro não característico do PDO";
			die;
		}
		// Caso nao exista
	} else {
		echo "Ocorreu algum erro, refaça novamente a operação.";
		echo '<p><a href="../form_crud/form_update_notaentrada.php/#atu_ven" 
			title="Refazer operação"><button>Botão refazer operação</button></a></p>';
		exit;
	}
	?>
</body>

</html>