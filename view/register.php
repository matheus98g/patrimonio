<?php
include('../includes/head.php') //scripts e html principal
?>
<script src="../js/cadastro.js"></script>
<style>
    body {
        background-image: url('../assets/images/background-login.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
        height: 100vh;
        color: white;
    }
</style>

<body class="bg-dark text-white">

    <div class="container mt-5 w-25">
        <h2 class="text-center">Criar um novo Usuario</h2>
        <form onsubmit="return validatePassword()" action="../controller/userController.php" method="POST">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario*</label>
                <input type="text" name="usuario" class="form-control" id="usuario" placeholder="Escolha um nome de usuairo" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email*</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Seu email" required>
            </div>
            <div class="mb-3">
                <label for="turma" class="form-label">Turma*</label>
                <input type="text" name="turma" class="form-control" id="turma" placeholder="Sua turma" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha*</label>
                <input type="password" class="form-control" id="password" placeholder="Informe uma senha" name="password" required>
                <div id="password-error-message" class="invalid-feedback">
                    <!-- Mensagem de erro da senha -->
                </div>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirme a senha*</label>
                <input type="password" class="form-control" id="confirm_password" placeholder="Confirme a senha" name="confirm_password" required>
                <div id="error-message" class="invalid-feedback">
                    Senhas não conferem!
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>

            <div class="text-center mt-3">
                <a href="dashboard.php" class="text-light">Voltar à Dashboard</a>
            </div>
        </form>
    </div>

</body>

</html>