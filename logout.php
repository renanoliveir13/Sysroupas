<?php
    session_start();
    if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
		die;
	}
    session_unset();
    session_destroy();
    echo "<script> alert('Você saiu do sistema! Até uma outra ocasião.'); location.href='/web/index.php' </script>"; 
?>