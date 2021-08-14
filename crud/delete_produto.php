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
	<title> DELETE | PRODUTO </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Deletar
		if(isset($_POST['Deletar'])){
			// Especifica a variavel
			$cd_produto = $_POST['cd_produto'];
			// Buscar nome do produto
			$procurar_nome = "SELECT nome FROM compra_produto WHERE cd_produto = :cd_produto";
			$busca_nome = $conexao->prepare($procurar_nome);
			$busca_nome->bindValue(':cd_produto',$cd_produto);
			$busca_nome->execute();
			$linha_nome = $busca_nome->fetch(PDO::FETCH_ASSOC);
			$nome_produto = $linha_nome['nome'];
			// Query que verifica se existe o registro de produto em venda
			$procurar_produto = "SELECT COUNT(cd_produto) AS countProduto FROM produtos_venda WHERE cd_produto = :cd_produto";
			$busca_produto = $conexao->prepare($procurar_produto);
			$busca_produto->bindValue(':cd_produto',$cd_produto);
			$busca_produto->execute();
			$linha = $busca_produto->fetch(PDO::FETCH_ASSOC);
			$countProduto = $linha['countProduto'];
			// Se o registro de produto existir na tabela venda
			if ($countProduto > 0) {
				$pluralSingular = $countProduto == 1 ? "uma venda" : "$countProduto vendas";
				$msg = "Você não pode apagar {$nome_produto} do sistema, pois está registrado em $pluralSingular. <br>";
				header('Location: /web/form_crud/form_delete_produto.php?id='.$cd_produto.'&error='.$msg);
				exit;
			}
			// Se a remocao for possivel de realizar
			try {
			    // Query que faz a remocao
			    $remove = "DELETE FROM compra_produto WHERE cd_produto = :cd_produto";
			    // $remocao recebe $conexao que prepare a operacao de exclusao
			    $remocao = $conexao->prepare($remove);
			    // Vincula um valor a um parametro
			    $remocao->bindValue(':cd_produto', $cd_produto);
			    // Executa a operacao
			    $remocao->execute();
			    // Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_select_produto.php/#nome');
				die;
			// Se a remocao nao for possivel de realizar
			} catch (PDOException $falha_remocao) {
			    $msg = "A remoção não foi feita".$falha_remocao->getMessage();
				header('Location: /web/form_crud/form_delete_produto.php?id='.$cd_produto.'&error='.$msg);
			    die;
			} catch (Exception $falha) {
				$msg= "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_delete_produto.php?id='.$cd_produto.'&error='.$msg);
				die;
			}
		// Caso nao exista
		} else {
			$msg = "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_delete_produto.php?id='.$cd_produto.'&error='.$msg);
			exit;
		} 
	?>
</body>
</html>