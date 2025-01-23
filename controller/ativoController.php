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

    public function cadastrarAtivo($data)
    {
        // Validação de dados
        $ativo = trim($data['ativo'] ?? '');
        $marca = intval($data['marca'] ?? 0);
        $tipo = intval($data['tipo'] ?? 0);
        $quantidade = intval($data['quantidade'] ?? 0);
        $observacao = trim($data['observacao'] ?? '');
        $userId = $_SESSION['id_user'] ?? null;

        if (empty($ativo) || $marca <= 0 || $tipo <= 0 || $quantidade <= 0 || !$userId) {
            return ['success' => false, 'message' => 'Dados inválidos. Por favor, preencha todos os campos corretamente.'];
        }

        try {
            // Query preparada para evitar SQL Injection
            $query = "INSERT INTO ativo (descricaoAtivo, qtdAtivo, obsAtivo, idMarca, idTipo, dataCadastro, idUsuario)
                      VALUES (:ativo, :quantidade, :observacao, :marca, :tipo, NOW(), :userId)";

            $stmt = $this->db->prepare($query);

            // Bind dos parâmetros
            $stmt->bindParam(':ativo', $ativo, PDO::PARAM_STR);
            $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
            $stmt->bindParam(':observacao', $observacao, PDO::PARAM_STR);
            $stmt->bindParam(':marca', $marca, PDO::PARAM_INT);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_INT);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

            // Executa a query
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Ativo cadastrado com sucesso!'];
            } else {
                return ['success' => false, 'message' => 'Erro ao cadastrar ativo.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro: ' . $e->getMessage()];
        }
    }

    public function editarAtivo($data)
    {
        // Validação de dados
        $id = intval($data['idAtivo'] ?? 0);
        $descricao = trim($data['descricaoAtivo'] ?? '');
        $quantidade = intval($data['qtdAtivo'] ?? 0);
        $observacao = trim($data['obsAtivo'] ?? '');
        $marca = intval($data['marca'] ?? 0);
        $tipo = intval($data['tipo'] ?? 0);

        if ($id <= 0 || empty($descricao) || $quantidade <= 0 || empty($observacao) || $marca <= 0 || $tipo <= 0) {
            return ['success' => false, 'message' => 'Dados inválidos. Por favor, preencha todos os campos.'];
        }

        try {
            // Query preparada para atualizar os dados
            $query = "UPDATE ativo 
                      SET descricaoAtivo = :descricao, qtdAtivo = :quantidade, obsAtivo = :observacao, 
                          idMarca = :marca, idTipo = :tipo 
                      WHERE idAtivo = :id";

            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
            $stmt->bindParam(':observacao', $observacao, PDO::PARAM_STR);
            $stmt->bindParam(':marca', $marca, PDO::PARAM_INT);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Ativo atualizado com sucesso!'];
            } else {
                return ['success' => false, 'message' => 'Erro ao atualizar ativo.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro: ' . $e->getMessage()];
        }
    }

    public function atualizarStatusAtivo($data)
    {
        $idAtivo = intval($data['idAtivo'] ?? 0);
        $statusAtivo = intval($data['statusAtivo'] ?? null);

        if (!$idAtivo || !isset($statusAtivo)) {
            return ['success' => false, 'message' => 'Parâmetros inválidos.'];
        }

        try {
            $query = "UPDATE ativo SET statusAtivo = :statusAtivo, dataAlteracao = NOW() WHERE idAtivo = :idAtivo";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':statusAtivo', $statusAtivo, PDO::PARAM_INT);
            $stmt->bindParam(':idAtivo', $idAtivo, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Status atualizado com sucesso.'];
            } else {
                return ['success' => false, 'message' => 'Erro ao atualizar o status.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro: ' . $e->getMessage()];
        }
    }

    public function cadastrarMarca($data)
    {
        $marca = trim($data['marca'] ?? '');
        $userId = $_SESSION['id_user'] ?? null;

        if (empty($marca) || !$userId) {
            return ['success' => false, 'message' => 'Dados inválidos.'];
        }

        try {
            $query = "INSERT INTO marca (descricaoMarca, statusMarca, idUsuario) VALUES (:marca, 'S', :userId)";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':marca', $marca, PDO::PARAM_STR);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Cadastro realizado com sucesso.'];
            } else {
                return ['success' => false, 'message' => 'Erro ao cadastrar marca.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro: ' . $e->getMessage()];
        }
    }

    public function cadastrarTipo($data)
    {
        // Validação de dados
        $descricaoTipo = trim($data['descricaoTipo'] ?? '');
        $userId = $_SESSION['id_user'] ?? null;

        if (empty($descricaoTipo) || !$userId) {
            return ['success' => false, 'message' => 'Dados inválidos. Por favor, preencha todos os campos corretamente.'];
        }

        try {
            // Query preparada para evitar SQL Injection
            $query = "INSERT INTO tipo (descricaoTipo, statusTipo, dataCadastro, idUsuario)
                  VALUES (:descricaoTipo, 'S', NOW(), :userId)";

            $stmt = $this->db->prepare($query);

            // Bind dos parâmetros
            $stmt->bindParam(':descricaoTipo', $descricaoTipo, PDO::PARAM_STR);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

            // Executa a query
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Tipo cadastrado com sucesso!'];
            } else {
                return ['success' => false, 'message' => 'Erro ao cadastrar tipo.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro: ' . $e->getMessage()];
        }
    }

    public function atualizarStatusTipo($data)
    {
        // Obtendo o ID do tipo e o status enviado via POST
        $idTipo = intval($data['idTipo'] ?? 0);
        $statusTipo = $data['statusTipo'] === '1' ? '1' : '0';

        // Verifica se os parâmetros necessários estão presentes
        if (!$idTipo || !isset($statusTipo)) {
            return ['success' => false, 'message' => 'Parâmetros inválidos.'];
        }

        try {
            // Query para atualizar o status do tipo
            $query = "UPDATE tipo SET statusTipo = :statusTipo, dataAlteracao = NOW() WHERE idTipo = :idTipo";
            $stmt = $this->db->prepare($query);

            // Bind dos parâmetros
            $stmt->bindParam(':statusTipo', $statusTipo, PDO::PARAM_STR);
            $stmt->bindParam(':idTipo', $idTipo, PDO::PARAM_INT);

            // Executa a query
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Status atualizado com sucesso.'];
            } else {
                return ['success' => false, 'message' => 'Erro ao atualizar o status.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro: ' . $e->getMessage()];
        }
    }
}

// Processa requisições AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    $db = conectarBanco();
    $ativoController = new Ativo($db);

    $action = $_POST['action'] ?? '';
    $data = $_POST;

    $response = ['success' => false, 'message' => 'Ação não reconhecida.'];

    if (method_exists($ativoController, $action)) {
        $response = $ativoController->$action($data);
    }

    echo json_encode($response);
}
