<?php
	// Classe Usuario
	class Usuario{
		// Metodo Logar criado
		public function Logar($email, $senha){
			// Recebe a variavel global $conexao do arquivo conexao.php
			global $conexao;
			// Verifica se o funcionario e a coluna de email existem no banco de dados
			$consulta = "SELECT * FROM funcionario WHERE email = :email LIMIT 1";
			// Prepara a conexão com o banco
			$consulta = $conexao->prepare($consulta);
			// Vincula um valor a um parametro
			$consulta->bindValue(':email', $email);
			// Executa a operacao
			$consulta->execute();

			// Condicao que retorna a quantidade de registros no banco de dados
			if ($consulta->rowCount() <= 0) {
				return false; // Login nao feito
			}
			
			// Retorna o array dos dados
			$dados = $consulta->fetch();

			// Verifica a senha
			if (!password_verify($senha, $dados['senha'])) {
				return false; // Login nao feito
			}

			// Variavel global da sessao que armazena a variavel cd_funcionario, nome e cargo
			$_SESSION['id_usuario'] = $dados['cd_funcionario'];
			$_SESSION['nome_usuario'] = $dados['nome'];
			$_SESSION['cargo_usuario'] = $dados['cargo'];
			return true; // Login feito
		}
		
		public function Verificar(){
			if (empty($_SESSION['id_usuario'])){
				echo "<script> alert('Ação inválida, entre no sistema da maneira correta.'); location.href='/web/index.php' </script>";
				die;
			}
		}
	}
?>