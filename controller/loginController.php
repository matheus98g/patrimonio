<?php

session_start();
include_once('../model/db.php');  // Inclui a função de conexão PDO
include_once('../controller/sessionController.php'); // Inclui a classe de autenticação (Auth)

if (isset($_SESSION['login_ok']) && $_SESSION['login_ok'] === true) {
    // Se o usuário já estiver logado, redireciona para o painel
    header('Location: ../view/dashboard.php');
    exit();
}

// Chama a função para obter a conexão PDO
$db = conectarBanco(); // Agora usando PDO

// Verificação do login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['password'];

    // Criação da instância da classe Auth e chamada do método de login
    $auth = new Auth($db);  // Passando a conexão PDO para o Auth
    $resultado = $auth->login($email, $senha);

    if ($resultado['success']) {
        // Login bem-sucedido, configurar as sessões
        $_SESSION['login_ok'] = true;
        $_SESSION['controle_login'] = true;
        $_SESSION['id_user'] = $resultado['idUsuario'];
        header('Location: ../view/dashboard.php');
        exit();
    } else {
        // Login falhou, redirecionar com erro
        $_SESSION['login_ok'] = false;
        header('Location: ../view/login.php?error_auth=s');
        exit();
    }
}
