<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand m-4" href="../view/dashboard.php">
            <img src="../assets/images/senac-logo.svg" width="80" class="d-inline-block align-top" alt="">
        </a>
        <button class="navbar-toggler m-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse m-4 justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../view/dashboard.php">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Usuários
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="../view/users.php">Listar todos</a></li>
                        <li><a class="dropdown-item" href="../view/register.php">Registrar</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Ativos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="../view/ativos.php">Listar Ativos</a></li>
                        <li><a class="dropdown-item" href="../view/marcas.php">Marcas</a></li>
                        <li><a class="dropdown-item" href="../view/tipos.php">Tipos</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../view/movimentacoes.php">Movimentações</a>
                </li>

            </ul>
            <div id="logout" class="m-4">
                <form method="post" action="logout.php">
                    <button type="submit" name="logout" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>

    </nav>
</div>