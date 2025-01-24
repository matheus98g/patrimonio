<?php

require_once('../model/db.php'); // Conexão com o banco de dados

class User
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Recuperar todos os usuários
    public function getAllUsers(): array
    {
        $query = "SELECT * FROM usuario ORDER BY nomeUsuario ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recuperar usuário pelo ID
    public function getUserById(int $id): ?array
    {
        $query = "SELECT * FROM usuario WHERE idUsuario = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    // Atualizar os dados do usuário
    // Atualizar os dados do usuário
    public function editarUsuario(array $data): array
    {
        try {
            // Validar entrada
            $id = intval($data['idUsuario'] ?? 0);
            $nome = trim($data['nomeUsuario'] ?? '');
            $email = trim($data['emailUsuario'] ?? '');
            $turma = trim($data['turmaUsuario'] ?? '');

            if (!$id || !$nome || !$email || !$turma) {
                return ['success' => false, 'message' => 'Dados incompletos para editar o usuário.'];
            }

            // Query para atualizar nome, email e turma
            $query = "UPDATE usuario SET nomeUsuario = :nome, emailUsuario = :email, turmaUsuario = :turma WHERE idUsuario = :id";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':turma', $turma);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            return ['success' => true, 'message' => 'Usuário atualizado com sucesso!'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro ao atualizar usuário: ' . $e->getMessage()];
        }
    }


    // Atualizar o status do usuário
    public function atualizarStatusUsuario($data)
    {
        // Obtendo o ID do Usuario e o status enviado via POST
        $idUsuario = intval($data['idUsuario'] ?? 0);
        $statusUsuario = $data['statusUsuario'] === '1' ? '1' : '0';

        // Verifica se os parâmetros necessários estão presentes
        if (!$idUsuario || !isset($statusUsuario)) {
            return ['success' => false, 'message' => 'Parâmetros inválidos.'];
        }

        try {
            // Query para atualizar o status do Usuario
            $query = "UPDATE usuario SET statusUsuario = :statusUsuario, dataAlteracao = NOW() WHERE idUsuario = :idUsuario";
            $stmt = $this->db->prepare($query);

            // Bind dos parâmetros
            $stmt->bindParam(':statusUsuario', $statusUsuario, PDO::PARAM_STR);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

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




    // Cadastrar um novo usuário
    public function createUser(string $nome, string $email, string $password, string $turma): array
    {
        try {
            // Verifica se o email já existe
            $query = "SELECT COUNT(*) FROM usuario WHERE emailUsuario = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->fetchColumn() > 0) {
                return ['success' => false, 'message' => 'Email já cadastrado.'];
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO usuario (nomeUsuario, emailUsuario, senhaUsuario, turmaUsuario, dataCadastro) 
                      VALUES (:nome, :email, :password, :turma, NOW())";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':turma', $turma);

            $stmt->execute();

            return ['success' => true, 'message' => 'Usuário cadastrado com sucesso!'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro ao cadastrar usuário: ' . $e->getMessage()];
        }
    }
}

// Processa requisições AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    $db = conectarBanco();
    $userController = new User($db);

    $action = $_POST['action'] ?? '';
    $data = $_POST;

    $response = ['success' => false, 'message' => 'Ação não reconhecida.'];

    if (method_exists($userController, $action)) {
        $response = $userController->$action($data);
    }

    echo json_encode($response);
}
