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
	<title> INSERT | PRODUTO </title>
	<link rel="stylesheet" href="/web/css/css.css">
</head>
<body>
	<?php
		// Se existir o botao de Inserir
		if(isset($_POST['Inserir'])){ 
			// Especifica a variavel
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
				$msg = "A quantidade, valor de compra ou a porcentagem de revenda do produto não pode ser igual ou menor que zero, refaça novamente a operação.";
				header('Location: /web/form_crud/form_insert_produto.php?error='.$msg);
				exit;
			}

			// Se a insercao for possivel de realizar
			try {
				// Query que faz a insercao	
				$insercao = "INSERT INTO compra_produto (nome,tipo,marca,codigo_barra,cor,tamanho,
				genero,quantidade,valor_compra,porcentagem_revenda,valor_revenda) 
				VALUES (:descricao,:tipo,:marca,:codigo_barra,:cor,:tamanho,:genero,:quantidade,
				:valor_compra,:porcentagem_revenda,:valor_revenda)";
				// $insere_dados recebe $conexao que prepare a operacao de insercao
				$insere_dados = $conexao->prepare($insercao);
				// Vincula um valor a um parametro
				$insere_dados->bindValue(':descricao', $descricao);
				$insere_dados->bindValue(':tipo', $tipo);
			    $insere_dados->bindValue(':marca', $marca);
			    $insere_dados->bindValue(':codigo_barra', $codigo_barra);
			    $insere_dados->bindValue(':cor', $cor);
			    $insere_dados->bindValue(':tamanho', $tamanho);
			    $insere_dados->bindValue(':genero', $genero);
			    $insere_dados->bindValue(':quantidade', $quantidade);
				$insere_dados->bindValue(':valor_compra', $valor_compra);
				$insere_dados->bindValue(':porcentagem_revenda', $porcentagem_revenda);
				$insere_dados->bindValue(':valor_revenda', $valor_revenda);
				// Executa a operacao
				$insere_dados->execute();
				// Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_select_produto.php/#nome');
				die;
			// Se a insercao nao for possivel de realizar
			} catch (PDOException $falha_insercao) {
			    $msg = "A inserção não foi feita".$falha_insercao->getMessage();
				header('Location: /web/form_crud/form_insert_produto.php?error='.$msg);
			    die;
			} catch (Exception $falha) {
				$msg = "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_insert_produto.php?error='.$msg);
				die;
			}
		// Caso nao exista
		} if(isset($_POST['Entrada'])){ 

			$cd_produto = $_POST['cd_produto'];			
			$quantidade = $_POST['quantidade'];

			// Se a quantidade ou valor do item for menor/igual a zero
			if ($quantidade <= 0 ) { 
				$msg = "A quantidade não pode ser igual ou menor que zero, refaça novamente a operação.";
				header('Location: /web/form_crud/form_insert_produtoentrada.php?id='.$cd_produto.'&error='.$msg);
				exit;
			}

			// Se a insercao for possivel de realizar
			try {
				// Query que faz a insercao	de historico de Entrada
				$insercao = "INSERT INTO produtos_entrada (cd_produto, quantidade)
				VALUES (:cd_produto,:quantidade)";
				// $insere_dados recebe $conexao que prepare a operacao de insercao
				$insere_dados = $conexao->prepare($insercao);
				// Vincula um valor a um parametro
				$insere_dados->bindValue(':cd_produto', $cd_produto);				
			    $insere_dados->bindValue(':quantidade', $quantidade);				
				// Executa a operacao
				$insere_dados->execute();

				//Atualizar Quantidade
				$update = $conexao->prepare("UPDATE compra_produto SET quantidade = quantidade + :quantidade WHERE cd_produto = :cd_produto");
				// Vincula o valor a um parametro
				$update->bindValue(":quantidade", $quantidade);
				$update->bindValue(":cd_produto", $cd_produto);
				// Executa a operacao
				$update->execute();
				
				// Retorna para a pagina de formulario de listagem
				header('Location: ../form_crud/form_select_produto.php/#nome');
				die;
			// Se a insercao nao for possivel de realizar
			} catch (PDOException $falha_insercao) {
			    $msg = "A inserção não foi feita".$falha_insercao->getMessage();
				header('Location: /web/form_crud/form_insert_produtoentrada.php?id='.$cd_produto.'&error='.$msg);
			    die;
			} catch (Exception $falha) {
				$msg = "Erro não característico do PDO".$falha->getMessage();
				header('Location: /web/form_crud/form_insert_produtoentrada.php?id='.$cd_produto.'&error='.$msg);
				die;
			}
			
		}else {
			$msg = "Ocorreu algum erro, refaça novamente a operação.";
			header('Location: /web/form_crud/form_select_produto.php?error='.$msg);
			exit;
		} 			
	?>
</body>
</html>