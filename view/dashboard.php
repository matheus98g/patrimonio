<?php
require_once('../controller/authController.php');
require_once('../model/db.php');

// Conectando ao banco de dados
$db = conectarBanco(); // Inicializa a conexão com o banco de dados

// Criando uma instância de Auth com a conexão do banco
$auth = new Auth($db);

// Verifica se a sessão está ativa
$auth->checkSession();



// Obtendo informações do usuário logado
$usuarioLogado = $_SESSION['usuario']; // Dados do usuário armazenados na sessão

require_once('../includes/head.php'); // Scripts e HTML principal
?>

<body>
    <?php include('../includes/menu.php'); ?>

    <div class="container mt-4">
        <h1>Dashboard</h1>
        <div class="alert alert-success" role="alert">
            Bem-vindo, <strong><?php echo htmlspecialchars($usuarioLogado['nomeUsuario']); ?></strong>!
        </div>

        <div>
            <p><strong>ID do Usuário:</strong> <?php echo htmlspecialchars($usuarioLogado['idUsuario']); ?></p>
            <p><strong>E-mail:</strong> <?php echo htmlspecialchars($usuarioLogado['emailUsuario']); ?></p>
            <p><strong>Permissão:</strong>
                <?php echo $usuarioLogado['isAdmin'] == 1 ? 'Administrador' : 'Usuário'; ?>
            </p>
        </div>
    </div>
</body>