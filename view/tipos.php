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

// Consultando os tipos
$sql = "SELECT idTipo, descricaoTipo, dataCadastro, statusTipo FROM tipo ORDER BY descricaoTipo ASC";
$stmt = $db->prepare($sql);
$stmt->execute();
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>Gestão de Tipos</title>
</head>

<script src="../js/tipos.js"></script>

<body>
    <?php require_once('../includes/menu.php'); ?>

    <div class="container mt-4">
        <h2 class="text-center">Lista de Tipos</h2>
        <button type="button" class="btn btn-primary m-4" data-bs-toggle="modal" data-bs-target="#cadastrarTipoModal">
            Cadastrar Tipo
        </button>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Data de Cadastro</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tipos)) : ?>
                        <?php foreach ($tipos as $tipo) : ?>
                            <tr>
                                <td><?= $tipo['idTipo']; ?></td>
                                <td><?= htmlspecialchars($tipo['descricaoTipo']); ?></td>
                                <td><?= (new DateTime($tipo['dataCadastro']))->format('d/m/Y H:i:s'); ?></td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input btn-alterar-status"
                                            type="checkbox"
                                            id="switchStatus-<?= $tipo['idTipo']; ?>"
                                            data-id="<?= $tipo['idTipo']; ?>"
                                            data-status="<?= $tipo['statusTipo']; ?>"
                                            <?= $tipo['statusTipo'] === 1 ? 'checked' : ''; ?>>
                                    </div>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editTipoModal"
                                        data-id="<?= $tipo['idTipo']; ?>"
                                        data-descricao="<?= htmlspecialchars($tipo['descricaoTipo']); ?>">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhum tipo encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>

    <!-- Modal para Adicionar Tipo -->
    <div class="modal fade" id="cadastrarTipoModal" tabindex="-1" aria-labelledby="cadastrarTipoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastrarTipoModalLabel">Cadastrar Tipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formCadastroTipo">
                        <div class="mb-3">
                            <label for="descricaoTipo" class="form-label">Descrição:</label>
                            <input type="text" id="descricaoTipo" class="form-control" required>
                        </div>
                        <button type="button" class="btn btn-primary w-100" id="cadastrarTipo">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Tipo -->
    <div class="modal fade" id="editTipoModal" tabindex="-1" aria-labelledby="editTipoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTipoModalLabel">Editar Tipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditTipo">
                        <input type="hidden" id="editIdTipo">
                        <div class="mb-3">
                            <label for="editDescricao" class="form-label">Descrição:</label>
                            <input type="text" id="editDescricao" class="form-control" required>
                        </div>
                        <button type="button" class="btn btn-primary w-100" id="editarTipo">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>