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
    <title>Cadastrar funcionário</title>
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
                <form method="POST" id="cad_forn" autocomplete="off" action="/web/crud/insert_funcionario.php" onsubmit="exibirNome()">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Cadastrar funcionário (Atalho = Alt + w)</h4>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6 pr-1">
                                                    <div class="form-group">
                                                        <label>Nome<span class="required"> *</span></label>
                                                        <input type="text" name="nome" id="nome" title="Campo para inserir o nome do funcionário" size="30" maxlength="30" required="" accesskey="w" class="form-control" placeholder="Ex: José da Silva">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pl-1">
                                                    <div class="form-group">
                                                        <label for="form-control">Cargo<span class="required"> *</span></label>
                                                        <select class="form-control"  name="cargo" id="cargo" required="" title="Caixa de seleção para escolher o cargo do funcionário" required="" class="form-control">
															<option value=""> Escolha um cargo</option>
															<option value="Atendente">Atendente</option>
															<option value="Gerente">Gerente</option>
														
														</select>
													</div>
                                                </div> 
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 pr-1">
                                                    <div class="form-group">
                                                        <label>CPF<span class="required"> *</span></label>
                                                        <input type="text" name="cpf" onkeypress="$(this).mask('000.000.000-00')" id="cpf" size="30" title="Campo para inserir o CPF do funcionário" minlength="14" required="" class="form-control" placeholder="Ex: 123.123.123-30">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pl-1">
                                                    <div class="form-group">
                                                        <label for="form-control">Telefone<span class="required"> *</span></label>
                                                        <input type="text" name="telefone" onkeypress="$(this).mask('(00) 0000-0000')" id="telefone" title="Campo para inserir o telefone do funcionário" size="30" minlength="14" required="" class="form-control" id="phone" name="phone" placeholder="Ex: (99) 9999-9999" pattern="(\([0-9]{2}\))\s([0-9]{0-9})?([0-9]{4})-([0-9]{4})" title="Número de telefone precisa ser no formato (99) 9999-9999" required="required" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 pr-1">
                                                    <div class="form-group">
                                                        <label>E-mail<span class="required"> *</span></label>
                                                        <input type="email" name="email" id="email" title="Campo para inserir o email de login do funcionário" size="30" maxlength="50" required="" class="form-control" placeholder="Ex: jose@gmail.com">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pl-1">
                                                    <div class="form-group">
                                                        <label for="form-control">Senha<span class="required"> *</span></label>
                                                        <input type="password" name="senha" id="senha" title="Campo para inserir a senha de login do funcionário" size="30" maxlength="32" required="" onclick="mostrarSenha()" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (!empty($_GET['error'])) { ?>

                                                <div class="alert alert-danger" role="alert">
                                                    <?= $_GET['error']; ?>
                                                </div>
                                            <?php } ?>
                                            <button type="submit" name="Inserir" title="Botão para cadastrar o fornecedor" class="btn btn-round btn-fill btn-info pull-right">Cadastrar</button>
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