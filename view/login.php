<?php
session_start();
if (isset($_GET['erro']) && $_GET['erro'] == 'sem_acesso') {
    echo "<script>alert('Usuário não autenticado. Por favor, faça login.');</script>";
}
if (isset($_GET['error_auth']) && $_GET['error_auth'] == 's') {
    echo "<script>alert('E-mail ou senha inválidos. Tente novamente.');</script>";
}

require_once('../includes/head.php');
?>

<body>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="form-container p-4 bg-dark text-light rounded shadow">
            <h2 class="text-center mb-4">Login</h2>
            <form method="POST" action="../controller/authController.php">
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control input-transparente" id="email" name="email" placeholder="Digite seu e-mail..." required>
                </div>
                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input type="password" class="form-control input-transparente" id="password" name="password" placeholder="Digite sua senha..." required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                <div class="text-center mt-3">
                    <a href="register.php" class="text-light">Criar uma conta</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>