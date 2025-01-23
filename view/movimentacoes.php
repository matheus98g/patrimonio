<?php
// Incluindo arquivos necessários
include_once('../controller/db_helper.php');
require_once('../controller/sessionController.php');
require_once('../model/db.php');

// Iniciando a sessão
session_start();

// Conectando ao banco de dados
$db = conectarBanco();

// Criando instância de autenticação e verificando sessão
$auth = new Auth($db);
$auth->checkSession();


?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>Movimentações</title>
</head>

<script src="../js/movimentacoes.js"></script>

<body>
    <?php require_once('../includes/menu.php'); ?>

    <div class="container mt-4">
        <h1>Movimentações</h1>

    </div>
</body>