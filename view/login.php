<?php
session_start();
if (isset($_GET['erro']) && $_GET['erro'] == 'sem_acesso') {
    echo "<script>alert('Usuario não autenticado')</script>";
}
if (isset($_GET['error_auth']) && $_GET['error_auth'] == 's') {
    echo "<script>alert('Usuario ou senha invalido'); </script>";
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário com Input Transparente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</head>

<body>
    <?php
    include('../includes/login_verify.php')
    ?>

    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="form-container">
            <h2>Login</h2>
            <form method="POST" action="../controller/loginController.php">
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