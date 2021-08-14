<div class="sidebar">
    <div class="sidebar-wrapper" style="background-color: #808080">
        <div class="logo">
            <a href="/web/inicio.php/#inicio" class="simple-text">
                <?php
                if ((isset($_SESSION['id_usuario'])) && (!empty($_SESSION['id_usuario']))) {
                    // Mensagem
                    echo "<small>Usuário: " . $_SESSION['nome_usuario'] . "</small><br/> ";
                    echo "<small>Cargo: " . $_SESSION['cargo_usuario'] . "</small>";
                    // Se nao
                }
                ?>
            </a>
        </div>
        <ul class="nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="no-icon">CLIENTE</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/web/form_crud/form_insert_cliente.php/#cad_cli" title="Cadastrar cliente"> Cadastrar cliente</a>
                    <a class="dropdown-item" href="/web/form_crud/form_select_cliente.php/#nome" title="Listar clientes"> Listar clientes</a>

            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="no-icon">FUNCIONÁRIO</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/web/form_crud/form_insert_funcionario.php/#cad_func" title="Cadastrar funcionário"> Cadastrar funcionário</a>
                    <a class="dropdown-item" href="/web/form_crud/form_select_funcionario.php/#nome" title="Listar funcionários"> Listar funcionários</a>

            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="no-icon">FORNECEDOR</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/web/form_crud/form_insert_fornecedor.php/#cad_forn" title="Cadastrar fornecedor"> Cadastrar fornecedor </a>
                    <a class="dropdown-item" href="/web/form_crud/form_select_fornecedor.php/#nome" title="Listar fornecedores"> Listar fornecedores </a>

            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="no-icon">PRODUTO</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/web/form_crud/form_insert_produto.php/#cad_pro" title="Cadastrar produto"> Cadastrar produto </a>
                    <a class="dropdown-item" href="/web/form_crud/form_select_produto.php/#nome" title="Listar produtos"> Listar produtos</a>

            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="no-icon">ENTRADA DE PRODUTO</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/web/form_crud/form_insert_notaentrada.php/#cad_pro" title="Cadastrar produto"> Cadastrar nota </a>
                    <a class="dropdown-item" href="/web/form_crud/form_select_notaentrada.php/#nome" title="Listar produtos"> Listar notas</a>

            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="no-icon">VENDA</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/web/form_crud/form_insert_venda.php/#cad_ven" title="Cadastrar venda"> Cadastrar venda</a>
                    <a class="dropdown-item" href="/web/form_crud/form_select_venda.php/#nome" title="Listar vendas"> Listar vendas</a>

            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="no-icon">DEVOLUÇÃO</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/web/form_crud/form_insert_devolucao.php/#cad_dev" title="Cadastrar devolução"> Cadastrar devolução </a>
                    <a class="dropdown-item" href="/web/form_crud/form_select_devolucao.php/#nome" title="Listar devoluções"> Listar devoluções</a>

            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="no-icon">FLUXO DE CAIXA</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/web/form_crud/caixa_venda.php/#fluxo_ven" title="Fluxo de vendas"> Fluxo de vendas</a>
                    <a class="dropdown-item" href="/web/form_crud/caixa_devolucao.php/#fluxo_dev" title="Fluxo de devoluções"> Fluxo de devoluções</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="no-icon">CONFIGURAÇÕES</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/web/form_crud/form_update_senha.php/#alt_senha" title="Alterar senha"> Alterar senha</a>
                    <a class="dropdown-item" href="/web/form_crud/form_area_adm.php/#area_adm" title="Área administrador"> Área administrador</a>
            </li>

            <form method="get" action="/web/logout.php">
                <input type="submit" value="SAIR" </input>
            </form>
        </ul>
    </div>
</div>

<?php if (!empty($error)) { ?>
    <div class="container">
        <div class="mx-5 alert alert-danger" role="alert">
            <?= $error; ?>
        </div>
    </div>
<?php } ?>