<?php
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

// Obtendo os dados da tabela "marca"
$data = get_data($db, 'marca'); // get_data deve ser uma função que retorna os dados com um SELECT
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

<script src="../js/marca.js"></script>

<body>
    <?php
    require_once('../includes/menu.php');
    ?>

    <div class="container p-4">
        <h2 class="text-center">Lista de Marcas</h2>
        <button type="button" class="btn btn-primary m-4" data-bs-toggle="modal" data-bs-target="#marcaModal" data-bs-whatever="@mdo">
            Cadastrar Marca
        </button>

        <?php
        require_once('../includes/modal_marcas.php');
        ?>
    </div>

    <div class="container" id="tabela-ativos">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($data)) {
                    foreach ($data as $marca) {
                ?>
                        <tr>
                            <td><?php echo htmlspecialchars($marca['idMarca']); ?></td>
                            <td><?php echo htmlspecialchars($marca['descricaoMarca']); ?></td>
                            <td>
                                <?php echo $marca['statusMarca'] ? 'Ativo' : 'Inativo'; ?>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="3" class="text-center">Nenhuma marca encontrada.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>