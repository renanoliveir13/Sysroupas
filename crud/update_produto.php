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
	<title> UPDATE | PRODUTO </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Atualizar
		if(isset($_POST['Atualizar'])){
			// Especifica a variavel
			$cd_produto = $_POST['cd_produto'];
			$descricao = $_POST['descricao'];
			$tipo = $_POST['tipo'];
			$marca = $_POST['marca'];
			$codigo_barra = $_POST['codigo_barra'];
			$cor = $_POST['cor'];
			$tamanho = $_POST['tamanho'];
			$genero = $_POST['genero'];
			$quantidade = $_POST['quantidade'];
			$valor_compra = $_POST['valor_compra'];
			$porcentagem_revenda = $_POST['porcentagem_revenda'];
			$valor_revenda = ($valor_compra + ($valor_compra * ($porcentagem_revenda / 100)));

			// Se a quantidade ou valor do item for menor/igual a zero
			if ($quantidade <= 0 || $valor_compra <= 0 || $porcentagem_revenda <= 0) { 
				$msg =  "A quantidade, valor de compra ou a porcentagem de revenda do produto não pode ser igual ou menor que zero, refaça novamente a operação.";
				header('Location: /web/form_crud/form_update_produto.php?id='.$cd_produto.'&error='.$msg);
				exit;
			}
				
			// Se a atualizacao for possivel de realizar
			try {
				// Query que faz a atualizacao
				$atualizacao = "UPDATE compra_produto SET nome = :nome, 
				tipo = :tipo, marca = :marca, codigo_barra = :codigo_barra, 
				cor = :cor, tamanho = :tamanho, genero = :genero, quantidade = :quantidade,
				valor_compra = :valor_compra, porcentagem_revenda = :porcentagem_revenda, 
				valor_revenda = :valor_revenda WHERE cd_produto = :cd_produto";
				// $atualiza_dados recebe $conexao que prepare a operacao de atualizacao
				$atualiza_dados = $conexao->prepare($atualizacao);
				// Vincula um valor a um parametro
				$atualiza_dados->bindValue(':cd_produto', $cd_produto);
				$atualiza_dados->bindValue(':nome', $descricao);
				$atualiza_dados->bindValue(':tipo', $tipo);
			    $atualiza_dados->bindValue(':marca', $marca);
			    $atualiza_dados->bindValue(':codigo_barra', $codigo_barra);
			    $atualiza_dados->bindValue(':cor', $cor);
			    $atualiza_dados->bindValue(':tamanho', $tamanho);
			    $atualiza_dados->bindValue(':genero', $genero);
				$atualiza_dados->bindValue(':quantidade', $quantidade);
			    $atualiza_dados->bindValue(':valor_compra', $valor_compra);
			    $atualiza_dados->bindValue(':porcentagem_revenda', $porcentagem_revenda);
			    $atualiza_dados->bindValue(':valor_revenda', $valor_revenda);
			    // Executa a operacao
			    $atualiza_dados->execute();
			    // Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_select_produto.php/#nome');
				die;
			// Caso a atualizacao for possivel de realizar
			} catch (PDOException $falha_atualizacao) {
			    $msg = "A atualização não foi feita".$falha_atualizacao->getMessage();
				header('Location: /web/form_crud/form_update_produto.php?id='.$cd_produto.'&error='.$msg);

			    die;
			} catch (Exception $falha) {
				$msg = "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_update_produto.php?id='.$cd_produto.'&error='.$msg);

				die;
			}
		// Caso nao exista
		} else {
			echo "Ocorreu algum erro, refaça novamente a operação.";
			echo '<p><a href="../form_crud/form_update_produto.php/#atu_pro" 
			title="Refazer operação"><button>Botão refazer operação</button></a></p>';
			exit;
		} 	
	?>
</body>
</html>