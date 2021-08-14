<?php
// Arquivo conexao.php
require_once 'conexao/conexao.php';
// Arquivo classe_usuario.php
require_once 'classe/classe_usuario.php';
$u = new Usuario();
$u->Verificar();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Início</title>
    <link rel="stylesheet" href="/web/css/css.css">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <link href="../assets/css/demo.css" rel="stylesheet" />
    <link rel="stylesheet" href="/web/css/estiloBotao.css"/>
    <script type="text/javascript" src="/web/js/atalho/inicio.js"></script>
</head>

<style>
img{
width:120px; 
margin-right:0px;
}
</style>

<body>
    <div class="wrapper">
	 <?php include(dirname(__FILE__) . '/layout/menu.php'); ?>

	  <?php
        // Se a selecao for possível de realizar
        try {
            // Query que faz a selecao
            $selecao = "SELECT COUNT(cd_cliente) AS qtd_cliente, 
            (SELECT COUNT(cd_funcionario) FROM funcionario) AS qtd_funcionario,
            (SELECT COUNT(cd_fornecedor) FROM fornecedor) AS qtd_fornecedor, 
            (SELECT COUNT(cd_produto) FROM compra_produto) AS qtd_produto, 
            (SELECT COUNT(cd_venda) FROM venda) AS qtd_venda, 
            (SELECT COUNT(cd_devolucao) FROM devolucao) AS qtd_devolucao FROM cliente";
            // $seleciona_dados recebe $conexao que prepare a operacao para selecionar
            $seleciona_dados = $conexao->prepare($selecao); 
            // Executa a operacao
            $seleciona_dados->execute();
            // Retorna uma matriz contendo todas as linhas do conjunto de resultados
            $linha = $seleciona_dados->fetchAll(PDO::FETCH_ASSOC);
        // Se a selecao nao for possivel de realizar
        } catch (PDOException $falha_selecao) {
            echo "A listagem de dados não foi feita".$falha_selecao->getMessage();
            die;
        } catch (Exception $falha) {
            echo "Erro não característico do PDO".$falha->getMessage();
            die;
        }
    ?>
   
  
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500" style="background-color: #DCDCDC">
                <div class="container-fluid">
            
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                      
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="">
                                    <span class="no-icon">SysRoupas</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- fim Navbar -->
            <div class="content ">
                    <div class="row ">
                        <div class="col-md-4 ">
                            <div class="card ">
                                <div class="card-header " >
                                    <h4><img src="https://img1.gratispng.com/20180320/vuw/kisspng-computer-icons-customer-icon-design-users-group-customer-group-customers-forum-people-users-ic-5ab19555d7e337.6245618515215875418843.jpg" class="card-title"><a href="/web/form_crud/form_select_cliente.php/#nome" title="Listar clientes"> <font color=black>CLIENTES </font></a></h4>
							    </div>
                                <div class="card-body ">
                                    <hr>
									<div class="stats">
                                        <i class=""></i> 
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-md-4">
                            <div class="card ">
									<div class="card-header ">
										<h4><img src="https://static.vecteezy.com/ti/vetor-gratis/p1/643462-icone-de-pessoas-do-grupo-gr%C3%A1tis-vetor.jpg" class="card-title"> <a href="/web/form_crud/form_select_funcionario.php/#nome"  title="Listar Funcionários"><font color=black>FUNCIONÁRIOS </font></a> </h4>
									</div>
                                <div class="card-body ">
                                  
                                    <hr>
									<div class="stats">
                                        <i class=""></i>  
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-md-4">
                            <div class="card ">
                                <div class="card-header ">
                                    <h4><img src="https://img.icons8.com/small/452/supplier.png" class="card-title"> <a href="/web/form_crud/form_select_fornecedor.php/#nome" title="Listar fornecedores"><font color=black>FORNCEDORES</font></a></h4>
							    </div>
                                <div class="card-body ">
                                  
                                    <hr>
									<div class="stats">
                                        <i class=""></i> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card ">
                                <div class="card-header ">
                                    <h4><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSq-XXQ_mGZWDHAgbOqAjKASQ4GWsT8I4SGcI9nCQpMut0nCaE1l45a29PfgMubiEgk0QM&usqp=CAU" class="card-title"><a href="/web/form_crud/form_select_venda.php/#nome" title="Listar vendas"><font color=black>VENDAS</font></a></h4>
							     </div>
                                <div class="card-body ">
                                  
                                    <hr>
									<div class="stats">
                                        <i class=""></i>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-md-4">
                            <div class="card ">
                                <div class="card-header ">
                                    <h4><img src="data:image/png;base64,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" class="card-title"><a href="/web/form_crud/form_select_produto.php/#nome" title="Listar produtos"><font color=black> PRODUTOS</font></a></h4>
							    </div>
                                <div class="card-body ">
                                  
                                    <hr>
									<div class="stats">
                                        <i class=""></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card ">
                                <div class="card-header ">
                                    <h4><img src="data:image/png;base64,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" class="card-title"><a href="/web/form_crud/form_select_devolucao.php/#nome" title="Listar devoluções"><font color=black>DEVOLUÇÕES</font></a></h4>
							     </div>
                                <div class="card-body ">
                                  
                                    <hr>
									<div class="stats">
                                        <i class=""></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
			</div>
        <footer class="footer" style="background-color: #DCDCDC">
                <div class="container-fluid">
                    <nav>
                     
                        <p class="copyright text-center">
                            ©
                            
                            WEB 2
                        </p>
                    </nav>
                </div>
        </footer>
        </div>
    </div>


</body>
<?php include(dirname(__FILE__) . '/layout/js.php'); ?>

<script type="text/javascript" src="/web/js/atalho/inicio.js"></script>


</html>