<?php

	// Se nao existir o id da sessao ou se a sessao nao estiver aberta
	if ((!session_id()) || (!isset($_SESSION))) {
		session_start();
	}

	// Se nao existir o botao de Entrar
	if (!isset($_POST['Entrar'])) {
		$msg = "Ação inválida, realize o login para acessar o sistema.";
		header('Location: /web/index.php?error='.$msg);
		die;
	}

	// Se os parametros de email ou senha forem vazios
	if ((empty($_POST['email'])) || (empty($_POST['senha']))) {
		$msg = "E-mail e senha não podem ser vazios, refaça novamente o login.";
		header('Location: /web/index.php?error='.$msg);
		die;
	}

	// Arquivo conexao.php
	require(dirname(__FILE__) . '/conexao/conexao.php');
	// Arquivo classe_usuario.php
	require(dirname(__FILE__) . '/classe/classe_usuario.php');
	
	// Criando uma instancia da classe Usuario
	$u = new Usuario();
	// Especifica a variavel
	$email = $_POST['email'];
	$senha = $_POST['senha'];

	// Verifica se o metodo for falso
	if ($u->Logar($email, $senha) == false) {
		$msg = "E-mail ou senha estão incorretos, refaça novamente o login.";
		header('Location: /web/index.php?error='.$msg);
		die;																								
	}																						

	// Sera redirecionado para a pagina inicio.php
	echo "<script> alert('{$_SESSION['nome_usuario']}, você acabou de entrar no sistema.'); location.href='/web/inicio.php/#inicio' </script>";
	die;
	
?>