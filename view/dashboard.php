<?php
require_once('../controller/sessionController.php');
require_once('../model/db.php');

session_start();

// Conectando ao banco de dados
$db = conectarBanco(); // Inicializa a conexão com o banco de dados

// Criando uma instância de Auth com a conexão do banco
$auth = new Auth($db);

// Verifica se a sessão está ativa
$auth->checkSession();

require_once('../includes/head.php'); //scripts e html principal
?>

<body>
    <?php
    include('../includes/menu.php')
    ?>
    <div class="container mt-4">
        <h1>Dashboard</h1>
    </div>
</body>