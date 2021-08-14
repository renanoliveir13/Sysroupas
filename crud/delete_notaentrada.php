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
	<title> DELETE | ENTRADA </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>

<body>
	<?php
	// Se existir o botão de Deletar
	if (isset($_POST['Deletar'])) {
		// Especifica a variável
		$cd_entrada = $_POST['cd_entrada'];
		$atualiza_quantidade = 0;
		
		// Se a remocao for possiel de realizar
		try {
			// Metodo que inicializa a(s) transacao(oes)
			$conexao->beginTransaction();
			// Busca registro da tabela entrada
			$procurar_produto = "SELECT cd_produto, quantidade FROM produtos_entrada WHERE cd_entrada = :cd_entrada";
			// $busca_registro recebe $procurar_produto que prepara a selecao do registro
			$busca_registro = $conexao->prepare($procurar_produto);
			// Vincula um valor a um parametro
			$busca_registro->bindValue(':cd_entrada', $cd_entrada);
			// Executa a operação
			$busca_registro->execute();
			while ($linha = $busca_registro->fetch(PDO::FETCH_ASSOC)) {

				// Variaveis a serem usadas no update da tabela produto
				$atualiza_quantidade = "UPDATE compra_produto SET quantidade = quantidade - :quantidade 
					WHERE cd_produto = :cd_produto";
				// $quantidade_produto recebe $conexao que prepara a transacao para atualiza o estoque na tabela produto
				$quantidade_produto = $conexao->prepare($atualiza_quantidade);
				$quantidade_produto->bindValue(':quantidade', $linha['quantidade']);
				$quantidade_produto->bindValue(':cd_produto', $linha['cd_produto']);
				// Executa a operacao
				$quantidade_produto->execute();
			}

			// TABELA entrada
			// Query que faz a remocao
			$remove = "DELETE FROM entrada WHERE cd_entrada = :cd_entrada";
			// $remocao recebe $conexao que prepare a operacao de exclusao
			$remocao = $conexao->prepare($remove);
			// Vincula um valor a um parametro
			$remocao->bindValue(':cd_entrada', $cd_entrada);
			// Executa a operacao
			$remocao->execute();

			

			$remove = "DELETE FROM produtos_entrada WHERE cd_entrada = :cd_entrada";
			// $remocao recebe $conexao que prepare a operacao de exclusao
			$remocao = $conexao->prepare($remove);
			// Vincula um valor a um parametro
			$remocao->bindValue(':cd_entrada', $cd_entrada);
			// Executa a operacao
			$remocao->execute();
			// TABELA PRODUTO
			
			// Confirma a execucao das query's em todas as transacoes 
			$conexao->commit();
			// Retorna para a pagina de formulario de listagem
			header('Location: ../form_crud/form_select_notaentrada.php/#nome');
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
		echo '<p><a href="../form_crud/form_delete_notaentrada.php/#exc_ven" 
			title="Refazer operação"><button>Botão Refazer operação</button></a></p>';
		exit;
	}
	?>
</body>

</html>