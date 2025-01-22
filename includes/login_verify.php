<?php
// Verificar se o formulário de login foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Buscar o usuário no banco de dados
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE nomeUsuario = ?");
    $stmt->execute([$usuario]);
    $usuario_bd = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se o usuário existe e se a senha fornecida é válida
    if ($usuario_bd && password_verify($senha, $usuario_bd['senha'])) {
        // Login bem-sucedido
        echo "Login bem-sucedido!";
        session_start();
        $_SESSION['usuario_id'] = $usuario_bd['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Usuário ou senha inválidos!";
    }
}
