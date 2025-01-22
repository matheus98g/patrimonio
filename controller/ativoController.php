<?php

require_once('../model/db.php');
require_once('sessionController.php');

class Ativo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function cadastrarAtivo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validação de dados
            $ativo = trim($_POST['ativo'] ?? '');
            $marca = intval($_POST['marca'] ?? 0);
            $tipo = intval($_POST['tipo'] ?? 0);
            $quantidade = intval($_POST['quantidade'] ?? 0);
            $observacao = trim($_POST['observacao'] ?? '');
            $userId = $_SESSION['id_user'] ?? null;

            if (empty($ativo) || $marca <= 0 || $tipo <= 0 || $quantidade <= 0 || !$userId) {
                echo "Dados inválidos. Por favor, preencha todos os campos corretamente.";
                return false;
            }

            // Query preparada para evitar SQL Injection
            $query = "INSERT INTO ativo (descricaoAtivo, qtdAtivo, obsAtivo, idMarca, idTipo, dataCadastro, idUsuario)
                      VALUES (?, ?, ?, ?, ?, NOW(), ?)";

            $stmt = $this->db->prepare($query);

            if (!$stmt) {
                echo "Erro ao preparar a consulta: " . $this->db->error;
                return false;
            }

            $stmt->bind_param('sisiii', $ativo, $quantidade, $observacao, $marca, $tipo, $userId);

            if ($stmt->execute()) {
                echo "Ativo cadastrado com sucesso!";
                return true;
            } else {
                echo "Erro ao cadastrar ativo: " . $stmt->error;
                return false;
            }
        }
    }
    public function editarAtivo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validação de dados
            $id = intval($_POST['idAtivo'] ?? 0);
            $descricao = trim($_POST['descricaoAtivo'] ?? '');
            $quantidade = intval($_POST['qtdAtivo'] ?? 0);
            $observacao = trim($_POST['obsAtivo'] ?? '');
            $marca = intval($_POST['marca'] ?? 0);
            $tipo = intval($_POST['tipo'] ?? 0);

            if ($id <= 0 || empty($descricao) || $quantidade <= 0 || empty($observacao) || $marca <= 0 || $tipo <= 0) {
                echo "Dados inválidos. Por favor, preencha todos os campos.";
                return false;
            }

            // Query preparada para atualizar os dados
            $query = "UPDATE ativo 
                      SET descricaoAtivo = ?, qtdAtivo = ?, obsAtivo = ?, idMarca = ?, idTipo = ? 
                      WHERE idAtivo = ?";

            $stmt = $this->db->prepare($query);

            if (!$stmt) {
                echo "Erro ao preparar a consulta: " . $this->db->error;
                return false;
            }

            $stmt->bind_param('sisiii', $descricao, $quantidade, $observacao, $marca, $tipo, $id);

            if ($stmt->execute()) {
                echo "Ativo atualizado com sucesso!";
                return true;
            } else {
                echo "Erro ao atualizar ativo: " . $stmt->error;
                return false;
            }
        }
    }

    function atualizarStatusAtivo($db, $idAtivo, $statusAtivo)
    {
        // Validação dos parâmetros
        if (!$idAtivo || !isset($statusAtivo)) {
            return ['success' => false, 'message' => 'Parâmetros inválidos.'];
        }

        // Query para atualização do status
        $sql = "UPDATE ativo SET statusAtivo = ?, dataAlteracao = NOW() WHERE idAtivo = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ii", $statusAtivo, $idAtivo);

        // Execução e retorno do resultado
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Status atualizado com sucesso.'];
        } else {
            return ['success' => false, 'message' => 'Erro ao atualizar o status.'];
        }
    }

    // // Uso da função dentro do contexto POST
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     $idAtivo = intval($_POST['idAtivo']);
    //     $statusAtivo = intval($_POST['statusAtivo']);

    //     // Chamada da função
    //     $response = atualizarStatusAtivo($db, $idAtivo, $statusAtivo);

    //     // Retorno em formato JSON
    //     echo json_encode($response);



    public function cadastrarMarca($marca, $userId)
    {
        // Valida a descrição da marca e o ID do usuário
        if (empty($marca) || !$userId) {
            return ['success' => false, 'message' => 'Dados inválidos.'];
        }

        // Prepara a consulta SQL
        $query = "INSERT INTO marca (descricaoMarca, statusMarca, idUsuario) VALUES (:marca, 'S', :userId)";
        $stmt = $this->db->prepare($query); // Usa o método prepare do PDO

        if (!$stmt) {
            return ['success' => false, 'message' => 'Erro ao preparar a consulta.'];
        }

        // Vincula os parâmetros corretamente
        $stmt->bindValue(':marca', $marca, PDO::PARAM_STR);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);

        // Verifica se a execução foi bem-sucedida
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Cadastro realizado com sucesso.'];
        } else {
            return ['success' => false, 'message' => 'Erro ao cadastrar marca: ' . $stmt->errorInfo()[2]];
        }
    }
}

// Verifica se foi uma requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    // Recupera a ação que o AJAX deseja executar
    $action = $_POST['action'] ?? '';

    // Conecta ao banco de dados
    $db = conectarBanco(); // Certifique-se de que esta função retorna uma instância de conexão do banco de dados

    // Cria a instância do controlador Ativo
    $ativoController = new Ativo($db);

    // Trata a ação que foi enviada pelo AJAX
    switch ($action) {
        case 'cadastrarMarca':
            // Recupera os dados enviados pelo AJAX
            $marca = trim($_POST['marca'] ?? '');
            $userId = $_SESSION['id_user'] ?? null; // Obtém o ID do usuário da sessão

            // Valida os dados recebidos
            if (empty($marca) || !$userId) {
                echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
                exit();
            }

            // Chama a função cadastrarMarca na classe Ativo
            $response = $ativoController->cadastrarMarca($marca, $userId);

            // Retorna a resposta para o AJAX
            echo json_encode($response);
            break;

        default:
            // Se a ação não for reconhecida, retorna erro
            echo json_encode(['success' => false, 'message' => 'Ação não reconhecida.']);
            break;
    }
}



// // Exemplo de uso do controlador
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     session_start();

//     $marca = $_POST['marca'] ?? '';
//     $userId = $_SESSION['id_user'] ?? null;

//     if (empty($marca) || !$userId) {
//         echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
//         exit();
//     }

//     $ativoController = new AtivoController($db);
//     $response = $ativoController->cadastrarMarca($marca, $userId);

//     echo json_encode($response);
// }
