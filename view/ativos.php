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

// Obtendo os dados necessários
$data = get_data($db, 'ativo');
$marcas = get_data($db, 'marca');
$tipos = get_data($db, 'tipo');

// Consultando os ativos com JOIN
$sql = "
    SELECT 
        idAtivo, 
        descricaoAtivo, 
        qtdAtivo, 
        statusAtivo, 
        obsAtivo, 
        (SELECT descricaoMarca FROM marca WHERE marca.idMarca = ativo.idMarca) AS marca, 
        (SELECT descricaoTipo FROM tipo WHERE tipo.idTipo = ativo.idTipo) AS tipo, 
        dataCadastro, 
        (SELECT nomeUsuario FROM usuario WHERE usuario.idUsuario = ativo.idUsuario) AS usuario
    FROM ativo;
";
$stmt = $db->prepare($sql);
$stmt->execute();
$ativos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>Gestão de Ativos</title>
</head>

<script src="../js/ativos.js"></script>

<body>
    <?php require_once('../includes/menu.php'); ?>

    <div class="container mt-4">
        <h2 class="text-center">Lista de Ativos</h2>
        <?php require_once('../includes/modal_ativos.php'); ?>
        <button type="button" class="btn btn-primary m-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Cadastrar Ativo
        </button>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Observação</th>
                        <th scope="col">Cadastrado por</th>
                        <th scope="col">Data Cadastro</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ativos)) : ?>
                        <?php foreach ($ativos as $ativo) : ?>
                            <tr>
                                <td><?= $ativo['idAtivo']; ?></td>
                                <td><?= htmlspecialchars($ativo['descricaoAtivo']); ?></td>
                                <td><?= htmlspecialchars($ativo['marca']); ?></td>
                                <td><?= htmlspecialchars($ativo['tipo']); ?></td>
                                <td><?= $ativo['qtdAtivo']; ?></td>
                                <td><?= htmlspecialchars($ativo['obsAtivo']); ?></td>
                                <td><?= htmlspecialchars($ativo['usuario']); ?></td>
                                <td><?= (new DateTime($ativo['dataCadastro']))->format('d/m/Y H:i:s'); ?></td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input btn-alterar-status"
                                            type="checkbox"
                                            id="switchStatus-<?= $ativo['idAtivo']; ?>"
                                            data-id="<?= $ativo['idAtivo']; ?>"
                                            data-status="<?= $ativo['statusAtivo']; ?>"
                                            <?= $ativo['statusAtivo'] ? 'checked' : ''; ?>>
                                    </div>
                                </td>

                                <td>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editAtivoModal"
                                        data-id="<?= $ativo['idAtivo']; ?>"
                                        data-descricao="<?= htmlspecialchars($ativo['descricaoAtivo']); ?>"
                                        data-quantidade="<?= $ativo['qtdAtivo']; ?>"
                                        data-observacao="<?= htmlspecialchars($ativo['obsAtivo']); ?>">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="10" class="text-center">Nenhum ativo encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Edição -->
    <div class="modal fade" id="editAtivoModal" tabindex="-1" aria-labelledby="editAtivoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAtivoModalLabel">Editar Ativo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="modal-id">
                        <div class="mb-3">
                            <label for="modal-descricao" class="form-label">Descrição:</label>
                            <input type="text" id="modal-descricao" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal-quantidade" class="form-label">Quantidade:</label>
                            <input type="number" id="modal-quantidade" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal-observacao" class="form-label">Observação:</label>
                            <textarea id="modal-observacao" class="form-control"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary w-100" id="saveEdit">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>