<?php
include('../model/db.php'); // Conexão com o banco de dados

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Recuperar usuário pelo ID
    public function getUser($id)
    {
        $query = "SELECT * FROM usuario WHERE idUsuario = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Atualizar os dados do usuário
    public function updateUser($id, $nome, $email, $turma)
    {
        $query = "UPDATE usuario SET nomeUsuario = ?, emailUsuario = ?, turmaUsuario = ? WHERE idUsuario = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssi", $nome, $email, $turma, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Redirecionamento com mensagem
    public function redirectWithMessage($message, $location)
    {
        echo "<script>alert('$message'); window.location.href = '$location';</script>";
        exit();
    }


    // Exemplo de uso da classe
    // $userHandler = new User($db);

    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     if (isset($_POST['id'])) {
    //         $id = intval($_POST['id']);
    //         $nome = $_POST['nome'] ?? '';
    //         $email = $_POST['email'] ?? '';
    //         $turma = $_POST['turma'] ?? '';

    //         // Atualizar os dados do usuário
    //         if ($userHandler->updateUser($id, $nome, $email, $turma)) {
    //             $userHandler->redirectWithMessage('Usuário atualizado com sucesso', '../view/users.php');
    //         } else {
    //             $userHandler->redirectWithMessage('Erro ao atualizar usuário', '../view/users.php');
    //         }
    //     } else {
    //         $userHandler->redirectWithMessage('ID não fornecido', '../view/dashboard.php');
    //     }
    // } elseif (isset($_GET['id'])) {
    //     $id = intval($_GET['id']);
    //     $user = $userHandler->getUser($id);

    //     if (!$user) {
    //         $userHandler->redirectWithMessage('Usuário não encontrado', '../view/dashboard.php');
    //     }
    // } else {
    //     $userHandler->redirectWithMessage('ID não fornecido', '../view/dashboard.php');
    // }

    // Função para cadastrar um novo usuário
    public function cadastrarUsuario($usuario, $email, $password, $turma)
    {
        $passwordCrip = base64_encode($password); // Criptografando a senha
        $query = "INSERT INTO usuario (nomeUsuario, emailUsuario, senhaUsuario, turmaUsuario, dataCadastro) 
                  VALUES (?, ?, ?, ?, now())";

        // Usando prepared statement para evitar SQL Injection
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssss", $usuario, $email, $passwordCrip, $turma);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Usuário cadastrado com sucesso!'];
        } else {
            return ['success' => false, 'message' => 'Ocorreu um erro, tente novamente.'];
        }
    }
    // // Exemplo de uso da classe UserController
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     $usuario = $_POST['usuario'] ?? '';
    //     $email = $_POST['email'] ?? '';
    //     $password = $_POST['password'] ?? '';
    //     $turma = $_POST['turma'] ?? '';

    //     if (empty($usuario) || empty($email) || empty($password) || empty($turma)) {
    //         echo "<script> alert('Por favor, preencha todos os campos.');
    //             window.location.href = '../view/cadastro.php';
    //         </script>";
    //         exit();
    //     }

    //     $userController = new UserController($db);
    //     $response = $userController->cadastrarUsuario($usuario, $email, $password, $turma);

    //     if ($response['success']) {
    //         echo "<script> alert('" . $response['message'] . "');
    //             window.location.href = '../view/login.php';
    //         </script>";
    //     } else {
    //         echo "<script> alert('" . $response['message'] . "');
    //             window.location.href = '../view/cadastro.php';
    //         </script>";
    //     }
    // }
}
