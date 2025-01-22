<?php
include('../controller/sessionController.php');
include('../includes/head.php'); //scripts e html principal
include_once('../controller/getDataController.php');

// Obter todos os usuários
$data = get_data($db, 'usuario');
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <?php

    include('../includes/menu.php');
    ?>

    <div class="container mt-4">
        <h2 class="text-center">Lista de Usuários</h2>
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Email</th>
                    <th scope="col">Turma</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data as $user) {
                ?>
                    <tr>
                        <td><?php echo $user['idUsuario']; ?></td>
                        <td><?php echo $user['nomeUsuario']; ?></td>
                        <td><?php echo $user['emailUsuario']; ?></td>
                        <td><?php echo $user['turmaUsuario']; ?></td>
                        <td>
                            <!-- Botão para acionar o modal -->
                            <button
                                class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal"
                                data-id="<?php echo $user['idUsuario']; ?>"
                                data-nome="<?php echo htmlspecialchars($user['nomeUsuario']); ?>"
                                data-email="<?php echo htmlspecialchars($user['emailUsuario']); ?>"
                                data-turma="<?php echo htmlspecialchars($user['turmaUsuario']); ?>">
                                Editar
                            </button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para edição -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../controller/editUserController.php" method="POST">
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
                        <button type="submit" class="btn btn-primary w-100">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Popula o modal com os dados do usuário ao clicar em "Editar"
        const editUserModal = document.getElementById('editUserModal');
        editUserModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Botão que acionou o modal
            const id = button.getAttribute('data-id');
            const nome = button.getAttribute('data-nome');
            const email = button.getAttribute('data-email');
            const turma = button.getAttribute('data-turma');

            // Preenche os campos do modal
            document.getElementById('modal-id').value = id;
            document.getElementById('modal-nome').value = nome;
            document.getElementById('modal-email').value = email;
            document.getElementById('modal-turma').value = turma;
        });
    </script>
</body>