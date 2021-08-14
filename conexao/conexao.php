<?php

	global $conexao; // Variavel global criada para ser usada em qualquer parte do sistema

	// Variaveis que definem a conexao do banco
	$host = 'localhost';
	$banco = 'web';
	$usuario = 'root';
	$senha = '';

	$error = "";

	// Se for possivel realizar a conexao
	try {

		// PDO e extensao do PHP para conectar com o banco de dados
		$conexao = new PDO("mysql:host=$host;dbname=$banco;charset=utf8",$usuario,$senha);
		$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexao->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
		//Inicalizar Sessão
		session_start();
	// Se nao for possivel fazer a conexao pelo PDO
	} catch (PDOException $falha) {
		echo "Erro na conexão do banco".$falha->getMessage();
		die;
	// Caso haja outro tipo de erro sem relacao PDO
	} catch (Exception $falha) {
		echo "Erro não proveniente do PDO".$falha->getMessage();
		die;
	}
?>
