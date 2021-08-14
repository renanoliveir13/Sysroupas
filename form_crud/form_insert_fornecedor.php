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
    <title>Cadastrar fornecedor</title>
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
                <form method="POST" id="cad_forn" autocomplete="off" action="/web/crud/insert_fornecedor.php" onsubmit="exibirNome()">


                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Cadastrar fornecedor (Atalho = Alt + w)</h4>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Nome <span class="required"> *</span></label>
                                                    <input type="text" name="nome" id="nome" title="Campo para inserir o nome do fornecedor" size="30" maxlength="30" required="" accesskey="w" title="Campo para inserir o nome do fornecedor" class="form-control" placeholder="Ex: Trapos PHP">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-1">
                                                <div class="form-group">
                                                    <label for="form-control">CNPJ<span class="required"> *</span></label>
                                                    <input type="text" name="cnpj" id="cnpj" onkeypress="$(this).mask('00.000.000/0000-00')" title="Campo para inserir o CNPJ do fornecedor" size="30" minlength="18" required="" class="form-control" placeholder="Ex: 12.123.123/1234-12">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label for="phone">Telefone <span class="required">*</span></label>
                                                    <input type="text" class="form-control" onkeypress="$(this).mask('(00) 0000-0000')" type="text" name="telefone" id="telefone" title="Campo para inserir o telefone do fornecedor" size="30" minlength="14" required="" placeholder="Ex: (99) 9999-9999" />
                                                </div>

                                            </div>
                                            <div class="col-md-6 pl-1">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email<span class="required"> *</span></label>
                                                    <input type="email" name="email" id="email" title="Campo para inserir o email do fornecedor" size="30" maxlength="50" required="" type="email" class="form-control" placeholder="Ex: trapos_php@gmail.com">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label for="uf" class="col-md-12 pl-0 control-label">Estado *</label>
                                                <select class="form-control" name="estado" id="estado" title="Caixa de seleção para escolher o estado do fornecedor" required="">
                                                    <option value="" title="Escolha o estado">Escolha o estado</option>
                                                    <option value="AC" title="Acre">Acre</option>
                                                    <option value="AL" title="Alagoas">Alagoas</option>
                                                    <option value="AM" title="Amazonas">Amazonas</option>
                                                    <option value="AP" title="Amapá">Amapá</option>
                                                    <option value="BA" title="Bahia">Bahia</option>
                                                    <option value="CE" title="Ceará">Ceará</option>
                                                    <option value="DF" title="Distrito Federal">Distrito Federal</option>
                                                    <option value="ES" title="Espírito Santo">Espiríto Santo</option>
                                                    <option value="GO" title="Goiás">Goiás</option>
                                                    <option value="MA" title="Maranhão">Maranhão</option>
                                                    <option value="MG" title="Minas Gerais">Minas Gerais</option>
                                                    <option value="MS" title="Mato Grosso do Sul">Mato Grosso do Sul</option>
                                                    <option value="MT" title="Mato Grosso">Mato Grosso</option>
                                                    <option value="PA" title="Paraíba">Paraíba</option>
                                                    <option value="PE" title="Pernambuco">Pernambuco</option>
                                                    <option value="PI" title="Piauí">Piauí</option>
                                                    <option value="PR" title="Paraná">Paraná</option>
                                                    <option value="RJ" title="Rio de Janeiro">Rio de Janeiro</option>
                                                    <option value="RN" title="Rio Grande do Norte">Rio Grande do Norte</option>
                                                    <option value="RO" title="Rondônia">Rondônia</option>
                                                    <option value="RR" title="Roraima">Roraima</option>
                                                    <option value="RS" title="Rio Grande do Sul">Rio Grande do Sul</option>
                                                    <option value="SC" title="Santa Catarina">Santa Catarina</option>
                                                    <option value="SE" title="Sergipe">Sergipe</option>
                                                    <option value="SP" title="Sergipe">Sergipe</option>
                                                    <option value="TO" title="Tocantins">Tocantins</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Cidade *</label>
                                                    <input type="text" name="cidade" id="cidade" title="Campo para inserir a cidade do fornecedor" size="30" maxlength="30" class="form-control" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-1">
                                                <div class="form-group">
                                                    <label>Bairro *</label>
                                                    <input type="text" class="form-control" name="bairro" id="bairro" title="Campo para inserir o bairro do fornecedor" size="30" maxlength="30" placeholder="" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 pr-1">
                                                <div class="form-group">
                                                    <label>Rua *</label>
                                                    <input type="text" name="endereco" id="endereco" title="Campo para inserir a rua do fornecedor" size="30" maxlength="30" class="form-control" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 px-1">
                                                <div class="form-group">
                                                    <label>Número *</label>
                                                    <input type="number" id="numero" pattern="\d+" title="Campo para inserir o número do comércio do fornecedor" name="numero" size="5" class="form-control" placeholder="" required>
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