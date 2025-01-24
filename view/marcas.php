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

// Consultando as marcas
$sql = "SELECT idMarca, descricaoMarca, statusMarca FROM marca ORDER BY descricaoMarca ASC";
$stmt = $db->prepare($sql);
$stmt->execute();
$marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>Gestão de Marcas</title>
</head>

<script src="../js/marcas.js"></script>

<body>
    <?php require_once('../includes/menu.php'); ?>

    <div class="container mt-4">
        <h2 class="text-center">Lista de Marcas</h2>
        <button type="button" class="btn btn-primary m-4" data-bs-toggle="modal" data-bs-target="#cadastrarMarcaModal">
            Cadastrar Marca
        </button>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($marcas)) : ?>
                        <?php foreach ($marcas as $marca) : ?>
                            <tr>
                                <td><?= $marca['idMarca']; ?></td>
                                <td><?= htmlspecialchars($marca['descricaoMarca']); ?></td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input btn-alterar-status"
                                            type="checkbox"
                                            id="status-switch-<?= $marca['idMarca']; ?>"
                                            data-id="<?= $marca['idMarca']; ?>"
                                            data-status="<?= $marca['statusMarca']; ?>"
                                            <?= $marca['statusMarca'] === 1 ? 'checked' : ''; ?>>
                                    </div>
                                </td>

                                <td>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editMarcaModal"
                                        data-id="<?= $marca['idMarca']; ?>"
                                        data-descricao="<?= htmlspecialchars($marca['descricaoMarca']); ?>">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhuma marca encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Adicionar Marca -->
    <div class="container mt-4">
        <div class="modal fade" id="cadastrarMarcaModal" tabindex="-1" aria-labelledby="cadastrarMarcaModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cadastrarMarcaModal">Cadastrar marca</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-1">
                                <label for="descricao_marca" class="col-form-label">Nome:</label>
                                <input type="text" class="form-control" id="descricao_marca">
                            </div>
                            <div class="modal-footer p-2">
                                <button type="reset" class="btn btn-secondary">Limpar</button>
                                <button type="button" class="btn btn-primary" id="cadastrar_marca">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Marca -->
    <div class="modal fade" id="editMarcaModal" tabindex="-1" aria-labelledby="editMarcaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMarcaModalLabel">Editar Marca</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditMarca">
                        <input type="hidden" id="editIdMarca">
                        <div class="mb-3">
                            <label for="editDescricaoMarca" class="form-label">Descrição:</label>
                            <input type="text" id="editDescricaoMarca" class="form-control" required>
                        </div>
                        <button type="button" class="btn btn-primary w-100" id="editarMarca">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>