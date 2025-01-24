<?php
// Incluindo arquivos necessários
include_once('../controller/db_helper.php');
require_once('../controller/authController.php');
require_once('../model/db.php');

// Verifica se a sessão está iniciada, caso contrário, inicia a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conectando ao banco de dados
$db = conectarBanco();  // Inicializa a conexão com o banco de dados

// Criando instância de autenticação
$auth = new Auth($db);

// Verifica se o usuário está logado
$auth->checkSession();  // Se não estiver logado, redireciona

// Obtendo informações do usuário logado
$usuarioLogado = $_SESSION['usuario']; // Dados do usuário armazenados na sessão

require_once('../includes/head.php'); // Scripts e HTML principal
?>

<script src="../js/movimentacoes.js"></script>

<body>
    <?php require_once('../includes/menu.php'); ?>

    <div class="container mt-4">
        <h1>Movimentações</h1>

    </div>
</body>