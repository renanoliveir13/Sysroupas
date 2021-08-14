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
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Cadastro</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <?php include(dirname(__FILE__) . '/../layout/css.php'); ?>

</head>

<body>
    <div class="wrapper">
        <?php include(dirname(__FILE__) . '/../layout/menu.php'); ?>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500" style="background-color: #DCDCDC">
                <div class="container-fluid">

                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="nav navbar-nav mr-auto">
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="no-icon">SysRoupas</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- fim Navbar -->
            <div class="content">
                
            <!-- FORMULARIO -->
			<!-- Navbar -->
			<nav class="navbar navbar-expand-lg " color-on-scroll="500" style="background-color: #DCDCDC">
                <div class="container-fluid">
            
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="nav navbar-nav mr-auto">
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <span class="no-icon">João Silva</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
			<!-- fim Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Excluir Fornecedor</h4>
                                </div>
                                <div class="card-body">
                                    <form>
									
										<div class="row">
                                            <div class="col-md-4 pr-1">
                                                <div class="form-group">
                                                    <label>ID fornecedor</label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                            </div>
                                            </div>
                                     
                                        <button type="submit" class="btn pull-right">Excluir</button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
                <button href="#" onclick='window.scrollTo({top: 0, behavior: "smooth"})' title="Botão voltar ao topo">Topo da página</button>

            </div>
            <footer class="footer" style="background-color: #DCDCDC">
                <div class="container-fluid">
                    <nav>

                        <p class="copyright text-center">
                            ©WEB 2
                        </p>
                    </nav>
                </div>
            </footer>
        </div>
        </form>
        <button href="#" onclick='window.scrollTo({top: 0, behavior: "smooth"})' title="Botão voltar ao topo">Topo da página</button>

    </div>

</body>
<?php include(dirname(__FILE__) . '/../layout/js.php'); ?>

</html>