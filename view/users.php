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

$auth->checkAdmin();

// Verifica se o usuário tem permissão de administrador
// $auth->checkAdmin();  // Se não for admin, redireciona


// Consultando os usuários
$sql = "SELECT idUsuario, nomeUsuario, emailUsuario, turmaUsuario, statusUsuario, dataCadastro FROM usuario ORDER BY nomeUsuario ASC";
$stmt = $db->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>Gestão de Usuários</title>
</head>

<script src="../js/usuarios.js"></script>

<body>

    <?php require_once('../includes/menu.php'); ?>

    <div class="container mt-4">
        <h2 class="text-center">Lista de Usuários</h2>

        <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#cadastrarUsuario">
            Cadastrar Usuário
        </button>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Turma</th>
                        <th>Data de Cadastro</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)) : ?>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?= htmlspecialchars($user['idUsuario']) ?></td>
                                <td><?= htmlspecialchars($user['nomeUsuario']) ?></td>
                                <td><?= htmlspecialchars($user['emailUsuario']) ?></td>
                                <td><?= htmlspecialchars($user['turmaUsuario']) ?></td>
                                <td><?= htmlspecialchars($user['dataCadastro']) ?></td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input btn-alterar-status"
                                            type="checkbox"
                                            id="status-switch-<?= $user['idUsuario']; ?>"
                                            data-id="<?= $user['idUsuario']; ?>"
                                            data-status="<?= $user['statusUsuario']; ?>"
                                            <?= $user['statusUsuario'] === 1 ? 'checked' : ''; ?>>
                                    </div>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editUserModal"
                                        data-id="<?= $user['idUsuario']; ?>"
                                        data-nome="<?= htmlspecialchars($user['nomeUsuario']); ?>"
                                        data-email="<?= htmlspecialchars($user['emailUsuario']); ?>"
                                        data-turma="<?= htmlspecialchars($user['turmaUsuario']); ?>">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center">Nenhum usuário encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Adicionar Usuário -->
    <div class="modal fade" id="cadastrarUsuario" tabindex="-1" aria-labelledby="cadastrarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastrarUsuarioLabel">Cadastrar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../controller/userController.php" method="POST">
                        <div class="mb-3">
                            <label for="nomeUsuario" class="form-label">Nome:</label>
                            <input type="text" id="nomeUsuario" name="nome" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="emailUsuario" class="form-label">E-mail:</label>
                            <input type="email" id="emailUsuario" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="turmaUsuario" class="form-label">Turma:</label>
                            <input type="text" id="turmaUsuario" name="turma" class="form-control" required>
                        </div>
                        <button type="button" class="btn btn-primary w-100">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Usuário -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../controller/userController.php" method="POST">
                        <input type="hidden" id="modal-id" name="id">
                        <div class="mb-3">
                            <label for="modal-nome" class="form-label">Nome:</label>
                            <input type="text" id="modal-nome" name="nome" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal-email" class="form-label">E-mail:</label>
                            <input type="email" id="modal-email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal-turma" class="form-label">Turma:</label>
                            <input type="text" id="modal-turma" name="turma" class="form-control" required>
                        </div>
                        <button type="button" class="btn btn-primary w-100" id="editarUsuario">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Popula o modal de edição com os dados do usuário
        document.getElementById('editUserModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            document.getElementById('modal-id').value = button.getAttribute('data-id');
            document.getElementById('modal-nome').value = button.getAttribute('data-nome');
            document.getElementById('modal-email').value = button.getAttribute('data-email');
            document.getElementById('modal-turma').value = button.getAttribute('data-turma');
        });
    </script>

</body>

</html>