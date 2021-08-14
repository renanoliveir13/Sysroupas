<?php
// Arquivo conexao.php
require_once '../conexao/conexao.php';
// Arquivo classe_usuario.php
require_once '../classe/classe_usuario.php';
// Inicio da sessao
session_start();
// Se existir $_SESSION['id_usuario'] e nao for vazio
if ((isset($_SESSION['id_usuario'])) && (!empty($_SESSION['id_usuario']))) {
	// Mensagem
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
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title> DELETE | VENDA </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>

<body>
	<?php
	// Se existir o botão de Deletar
	if (isset($_POST['Deletar'])) {
		// Especifica a variável
		$cd_venda = $_POST['cd_venda'];
		$atualiza_quantidade = 0;
		// Query que verifica se existe o registro de venda em devolucao
		$procurar_key = "SELECT COUNT(produtos_devolucao.cd_produto_venda) AS countDevolucao FROM produtos_devolucao INNER JOIN produtos_venda ON produtos_venda.cd_produto_venda = produtos_devolucao.cd_produto_venda WHERE produtos_venda.cd_venda = :cd_venda";
		$busca_key = $conexao->prepare($procurar_key);
		$busca_key->bindValue(':cd_venda', $cd_venda);
		$busca_key->execute();
		$linha2 = $busca_key->fetch(PDO::FETCH_ASSOC);
		$countDevolucao = $linha2['countDevolucao'];
		// Se o registro de venda existir na tabela devolucao 
		if ($countDevolucao > 0) {
			$pluralSingular = $countDevolucao == 1 ? "uma devolução" : "$countDevolucao devoluções";
			echo "Você não pode apagar esse registro de venda, pois está sendo usado em $pluralSingular.";
			echo '<p><a href="../form_crud/form_delete_venda.php/#exc_ven" 
				title="Refazer operação"><button>Botão refazer operação</button></a></p>';
			exit;
		}

		// Se a remocao for possiel de realizar
		try {
			// Metodo que inicializa a(s) transacao(oes)
			$conexao->beginTransaction();
			// Busca registro da tabela venda
			$procurar_produto = "SELECT cd_produto, quantidade FROM produtos_venda WHERE cd_venda = :cd_venda";
			// $busca_registro recebe $procurar_produto que prepara a selecao do registro
			$busca_registro = $conexao->prepare($procurar_produto);
			// Vincula um valor a um parametro
			$busca_registro->bindValue(':cd_venda', $cd_venda);
			// Executa a operação
			$busca_registro->execute();
			while ($linha = $busca_registro->fetch(PDO::FETCH_ASSOC)) {
				// Variaveis a serem usadas no update da tabela produto
				$quantidade[$linha['cd_produto']] = $linha['quantidade'];
			}
			// TABELA VENDA
			// Query que faz a remocao
			$remove = "DELETE FROM venda WHERE cd_venda = :cd_venda";
			// $remocao recebe $conexao que prepare a operacao de exclusao
			$remocao = $conexao->prepare($remove);
			// Vincula um valor a um parametro
			$remocao->bindValue(':cd_venda', $cd_venda);
			// Executa a operacao
			$remocao->execute();
			$remove = "DELETE FROM produtos_venda WHERE cd_venda = :cd_venda";
			// $remocao recebe $conexao que prepare a operacao de exclusao
			$remocao = $conexao->prepare($remove);
			// Vincula um valor a um parametro
			$remocao->bindValue(':cd_venda', $cd_venda);
			// Executa a operacao
			$remocao->execute();
			// TABELA PRODUTO
			// Query que faz a atualizacao da quantidade de estoque da tabela produto
			foreach ($quantidade as $cd_produto => $qtd) {
				$atualiza_quantidade = "UPDATE compra_produto SET quantidade = quantidade + :quantidade 
					WHERE cd_produto = :cd_produto";
				// $quantidade_produto recebe $conexao que prepara a transacao para atualiza o estoque na tabela produto
				$quantidade_produto = $conexao->prepare($atualiza_quantidade);
				$quantidade_produto->bindValue(':quantidade', $qtd);
				$quantidade_produto->bindValue(':cd_produto', $cd_produto);
				// Executa a operacao
				$quantidade_produto->execute();
			}
			// Confirma a execucao das query's em todas as transacoes 
			$conexao->commit();
			// Retorna para a pagina de formulario de listagem
			header('Location: ../form_crud/form_select_venda.php/#nome');
			die;
			// Se a remocao nao for possivel de realizar
		} catch (PDOException $falha_remocao) {
			echo "A remoção não foi feita" . $falha_remocao->getMessage();
			die;
		} catch (Exception $falha) {
			echo "Erro não característico do PDO" . $falha->getMessage();
			die;
		}
		// Caso nao exista
	} else {
		echo "Ocorreu algum erro, refaça novamente a operação.";
		echo '<p><a href="../form_crud/form_delete_venda.php/#exc_ven" 
			title="Refazer operação"><button>Botão Refazer operação</button></a></p>';
		exit;
	}
	?>
</body>

</html>