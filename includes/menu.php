<?php
// Verifica se o usuário logado é administrador
$usuarioLogado = $_SESSION['usuario'];

// Captura o nome do script atual
$paginaAtual = basename($_SERVER['PHP_SELF']);
?>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="d-flex w-100 justify-content-between align-items-center">
            <!-- Logo -->
            <div class="navbar-brand">
                <a href="../view/dashboard.php">
                    <img src="../assets/images/senac-logo.svg" width="80" class="d-inline-block align-top" alt="Logo">
                </a>
            </div>

            <!-- Navbar items -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav" style="font-weight: 500;">
                    <li class="nav-item">
                        <a class="nav-link <?= $paginaAtual === 'dashboard.php' ? 'bg-primary text-white rounded' : '' ?>" href="../view/dashboard.php">Início</a>
                    </li>
                    <?php if ($usuarioLogado['isAdmin'] == 1) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= in_array($paginaAtual, ['users.php', 'register.php']) ? 'bg-primary text-white rounded' : '' ?>" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Usuários
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item <?= $paginaAtual === 'users.php' ? 'bg-primary text-white rounded' : '' ?>" href="../view/users.php">Listar todos</a></li>
                                <li><a class="dropdown-item <?= $paginaAtual === 'register.php' ? 'bg-primary text-white rounded' : '' ?>" href="../view/register.php">Cadastrar Usuário</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= in_array($paginaAtual, ['ativos.php', 'marcas.php', 'tipos.php']) ? 'bg-primary text-white rounded' : '' ?>" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ativos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item <?= $paginaAtual === 'ativos.php' ? 'bg-primary text-white rounded' : '' ?>" href="../view/ativos.php">Listar Ativos</a></li>
                            <li><a class="dropdown-item <?= $paginaAtual === 'marcas.php' ? 'bg-primary text-white rounded' : '' ?>" href="../view/marcas.php">Marcas</a></li>
                            <li><a class="dropdown-item <?= $paginaAtual === 'tipos.php' ? 'bg-primary text-white rounded' : '' ?>" href="../view/tipos.php">Tipos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $paginaAtual === 'movimentacoes.php' ? 'bg-primary text-white rounded' : '' ?>" href="../view/movimentacoes.php">Movimentações</a>
                    </li>
                </ul>
            </div>

            <!-- Logout button -->
            <div class="text-end">
                <form method="post" action="logout.php">
                    <button type="submit" name="logout" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>
</div>