<?php
session_start();
if (isset($_POST['logout'])) {
    // Finaliza a sessão
    session_unset();  // Remove todas as variáveis da sessão
    session_destroy(); // Destroi a sessão
    header("Location: login.php"); // Redireciona para a página de login
    exit();
}
