<?php
// require_once('../includes/head.php'); // Scripts e HTML principal
include_once('../controller/db_helper.php'); // Incluindo o helper do banco
require_once('../controller/sessionController.php');
require_once('../model/db.php');

// Cria uma instância de Auth e chama o método checkSession
// Iniciando a sessão
session_start();

// Conectando ao banco de dados
$db = conectarBanco(); // Inicializa a conexão com o banco de dados

// Criando uma instância de Auth com a conexão do banco
$auth = new Auth($db);

// Verifica se a sessão está ativa
$auth->checkSession();

// Obtendo os dados necessários
$data = get_data($db, 'ativo');
$marcas = get_data($db, 'marca');
$tipos = get_data($db, 'tipo');

// Consultar ativos com join
$sql = "
    SELECT 
        idAtivo, 
        descricaoAtivo, 
        qtdAtivo, 
        statusAtivo, 
        obsAtivo, 
        (SELECT descricaoMarca from marca m WHERE m.idMarca = a.idMarca) as marca, 
        (SELECT descricaoTipo from tipo t WHERE t.idTipo = a.idTipo) as tipo, 
        dataCadastro, 
        dataAlteracao, 
        (SELECT nomeUsuario from usuario u WHERE u.idUsuario = a.idUsuario) as usuario
    FROM ativo a
";
$stmt = $db->prepare($sql);
$stmt->execute(); // Executando a consulta
$ativos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <?php include('../includes/menu.php'); ?>

    <div class="container mt-4">
        <h2 class="text-center">Lista de Ativos</h2>
        <?php
        include_once('../includes/modal_ativos.php');
        ?>
        <button type="button" class="btn btn-primary m-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Cadastrar Ativo
        </button>
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
                    <!-- <th scope="col">Status</th> -->
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($ativos as $ativo) {
                ?>
                    <tr>
                        <td><?php echo $ativo['idAtivo']; ?></td>
                        <td><?php echo $ativo['descricaoAtivo']; ?></td>
                        <td><?php echo $ativo['marca']; ?></td>
                        <td><?php echo $ativo['tipo']; ?></td>
                        <td><?php echo $ativo['qtdAtivo']; ?></td>
                        <td><?php echo $ativo['obsAtivo']; ?></td>
                        <td><?php echo $ativo['usuario']; ?></td>
                        <td>
                            <?php
                            $dataCadastro = new DateTime($ativo['dataCadastro']);
                            echo $dataCadastro->format('d/m/Y H:i:s');
                            ?>
                        </td>

                        <td>
                            <div id="ativar-inativar-ativo" class="d-flex justify-content-evenly">
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="switchStatus-<?php echo $ativo['idAtivo']; ?>"
                                        data-id="<?php echo $ativo['idAtivo']; ?>"
                                        <?php echo $ativo['statusAtivo'] ? 'checked' : ''; ?>>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div id="acoes" class="d-flex justify-content-evenly">
                                <div id="editar-ativo">
                                    <button
                                        class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editAtivoModal"
                                        data-id="<?php echo $ativo['idAtivo']; ?>"
                                        data-descricao="<?php echo htmlspecialchars($ativo['descricaoAtivo']); ?>"
                                        data-quantidade="<?php echo htmlspecialchars($ativo['qtdAtivo']); ?>"
                                        data-observacao="<?php echo htmlspecialchars($ativo['obsAtivo']); ?>">
                                        Editar
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
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
                    <form action="../controller/editAtivoController.php" method="POST">
                        <input type="hidden" id="modal-id" name="idAtivo">
                        <div class="mb-3">
                            <label for="modal-descricao" class="form-label">Descrição:</label>
                            <input type="text" id="modal-descricao" name="descricaoAtivo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal-quantidade" class="form-label">Quantidade:</label>
                            <input type="number" id="modal-quantidade" name="qtdAtivo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal-observacao" class="form-label">Observação:</label>
                            <textarea id="modal-observacao" name="obsAtivo" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para confirmação -->
    <div class="modal fade" id="confirmStatusModal" tabindex="-1" aria-labelledby="confirmStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmStatusModalLabel">Confirmação de Alteração de Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja alterar o status deste ativo?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal-conf-status-cancelar">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmStatusChange">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentCheckbox; // Para rastrear o checkbox atual

        // Captura o evento de mudança no checkbox
        document.querySelectorAll('.form-check-input').forEach((checkbox) => {
            checkbox.addEventListener('change', function(event) {
                currentCheckbox = this; // Armazena o checkbox atual
                // Exibe o modal
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmStatusModal'));
                confirmModal.show();
            });
        });

        // Confirmação no modal
        document.getElementById('confirmStatusChange').addEventListener('click', function() {
            const idAtivo = currentCheckbox.getAttribute('data-id');
            const newStatus = currentCheckbox.checked ? 1 : 0;
            console.log(newStatus);

            // Aqui você pode fazer uma requisição AJAX para atualizar o status no servidor
            $.ajax({
                url: '../controller/updateStatusController.php',
                type: 'POST',
                data: {
                    idAtivo,
                    statusAtivo: newStatus
                },
                success: function(response) {
                    // Mensagem de sucesso ou manipulação do DOM se necessário
                    console.log(response);
                    location.reload();
                },
                error: function(error) {
                    console.error(error);
                    // Reverte o status em caso de erro
                    currentCheckbox.checked = !currentCheckbox.checked;
                    alert('Erro ao atualizar o status. Tente novamente.');
                }
            });

            // Fecha o modal
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmStatusModal'));
            confirmModal.hide();
        });
        document.getElementById('modal-conf-status-cancelar').addEventListener('click', function() {
            location.reload();
        });
    </script>

</body>