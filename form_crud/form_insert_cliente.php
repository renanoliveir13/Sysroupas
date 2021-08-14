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
    <title>Cadastrar cliente</title>
	 <link rel="stylesheet" href="/web/css/estiloBotao.css"/>
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
                <form method="POST" id="cad_cli" autocomplete="off" action="/web/crud/insert_cliente.php" onsubmit="exibirNome()">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Cadastrar cliente (Atalho = Alt + w)</h4>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6 pr-1">
                                                    <div class="form-group">
                                                        <label>Nome <span class="required"> *</span></label>
                                                        <input type="text" name="nome" id="nome" class="form-control" title="Campo para inserir o nome do cliente" placeholder="Ex: José da Silva" size="30" maxlength="30" required="" accesskey="w">

                                                    </div>
                                                </div>
                                                <div class="col-md-6 pl-1">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">CPF <span class="required"> *</span></label>
                                                        <input type="text" name="cpf" class="form-control " onkeypress="$(this).mask('000.000.000-00')" id="cpf" .mask() cpf-mask="000.000.000-00" maxlength="11" autocomplete="off" title="Campo para inserir o CPF do cliente" placeholder="Ex: 123.123.123-30" size="30" minlength="14" required="">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6 pr-1">
                                                    <div class="form-group">
                                                        <label for="phone">Telefone <span class="required">*</span></label>
                                                        <input type="text" id="telefone" class="form-control" onkeypress="$(this).mask('(00) 0000-0000')" name="telefone" placeholder="Ex: (99) 9999-9999" pattern="(\([0-9]{2}\))\s([0-9]{0-9})?([0-9]{4})-([0-9]{4})" title="Campo para inserir o telefone do cliente" size="30" minlength="14" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pl-1">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email <span class="required"> *</span></label>
                                                        <input type="email" id="email" class="form-control" name="email" placeholder="Ex: jose@gmail.com" title="Campo para inserir o email do cliente" size="30" maxlength="50" required="">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 pr-1">
                                                    <div class="form-group">
                                                        <label>Cidade *</label>
                                                        <input type="text" class="form-control" id="cidade" name="cidade" placeholder="" size="30" title="Campo para inserir a cidade do cliente" maxlength="30" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pl-1">
                                                    <div class="form-group">
                                                        <label>Bairro *</label>
                                                        <input type="text" id="bairro" class="form-control" name="bairro" size="30" title="Campo para inserir o bairro do cliente" maxlength="30" required="">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 pr-1">
                                                    <div class="form-group">
                                                        <label>Rua *</label>
                                                        <input type="text" id="rua" name="rua" class="form-control" title="Campo para inserir o nome da rua do cliente" size="30" maxlength="30" required="">

                                                    </div>
                                                </div>
                                                <div class="col-md-4 px-1">
                                                    <div class="form-group">
                                                        <label>Número *</label>
                                                        <input type="number" id="numero" class="form-control" pattern="\d+" title="Campo para inserir o número da casa do cliente" name="numero" size="5" required=""> </p>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (!empty($_GET['error'])) { ?>

                                                <div class="alert alert-danger" role="alert">
                                                    <?= $_GET['error']; ?>
                                                </div>
                                            <?php } ?>
                                            <button type="submit" name="Inserir" title="Botão para cadastrar o cliente" class="btn btn-info btn-round btn-fill pull-right">Cadastrar</button>
                                            <div class="clearfix"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
				</br>
                
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
        
    </div>

</body>
<?php include(dirname(__FILE__) . '/../layout/js.php'); ?>

</html>