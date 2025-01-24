<?php
// Incluindo arquivos necessários
include_once('../controller/db_helper.php');
require_once('../controller/authController.php');
require_once('../controller/ativoController.php');
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
$auth->checkSession();

// Verifica se o usuário tem permissão de administrador
$auth->checkAdmin();

// Consultando as movimentações
$ativos = new Ativo($db);

$movimentacoes = $ativos->getMovimentacoes($db);

?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>Gestão de Movimentações</title>
</head>

<body>

    <?php require_once('../includes/menu.php'); ?>

    <div class="container mt-4">
        <h2 class="text-center">Lista de Movimentações</h2>

        <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#cadastrarMovimentacao">
            Nova Movimentação
        </button>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>Ativo</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Quantidade Uso</th>
                        <th>Quantidade Mov.</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($movimentacoes)) : ?>
                        <?php foreach ($movimentacoes as $mov) : ?>
                            <tr>
                                <td><?= htmlspecialchars($mov['idMovimentacao']) ?></td>
                                <td><?= htmlspecialchars($mov['nomeUsuario']) ?></td>
                                <td><?= htmlspecialchars($mov['nomeAtivo']) ?></td>
                                <td><?= htmlspecialchars($mov['localOrigem']) ?></td>
                                <td><?= htmlspecialchars($mov['localDestino']) ?></td>
                                <td><?= htmlspecialchars($mov['quantidadeUso']) ?></td>
                                <td><?= htmlspecialchars($mov['quantidadeMov']) ?></td>
                                <td><?= htmlspecialchars($mov['tipoMovimentacao']) ?></td>
                                <td><?= htmlspecialchars($mov['statusMov']) ?></td>
                                <td><?= htmlspecialchars($mov['dataMovimentacao']) ?></td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editMovModal"
                                        data-id="<?= $mov['idMovimentacao']; ?>"
                                        data-origem="<?= htmlspecialchars($mov['localOrigem']); ?>"
                                        data-destino="<?= htmlspecialchars($mov['localDestino']); ?>"
                                        data-tipo="<?= htmlspecialchars($mov['tipoMovimentacao']); ?>">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="11" class="text-center">Nenhuma movimentação encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Adicionar Movimentação -->
    <div class="modal fade" id="cadastrarMovimentacao" tabindex="-1" aria-labelledby="cadastrarMovimentacaoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastrarMovimentacaoLabel">Nova Movimentação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../controller/movimentacaoController.php" method="POST">
                        <div class="mb-3">
                            <label for="localOrigem" class="form-label">Local de Origem:</label>
                            <input type="text" id="localOrigem" name="localOrigem" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="localDestino" class="form-label">Local de Destino:</label>
                            <input type="text" id="localDestino" name="localDestino" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantidadeMov" class="form-label">Quantidade Movimentada:</label>
                            <input type="number" id="quantidadeMov" name="quantidadeMov" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipoMovimentacao" class="form-label">Tipo de Movimentação:</label>
                            <input type="text" id="tipoMovimentacao" name="tipoMovimentacao" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>