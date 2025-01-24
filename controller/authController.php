<?php
require_once('../model/db.php');

class Auth
{
    private $db;

    // Construtor para inicializar a conexão com o banco de dados e garantir a sessão
    public function __construct($db)
    {
        $this->db = $db;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Função de login
    public function login($email, $senha)
    {
        // Criptografa a senha para comparação
        $senhaCrip = base64_encode($senha);

        // Prepara a consulta para evitar injeção de SQL
        $sql = "SELECT COUNT(*) AS quantidade, idUsuario, isAdmin, nomeUsuario, emailUsuario 
                FROM usuario 
                WHERE emailUsuario = :email AND senhaUsuario = :senha";

        // Prepara a consulta PDO
        $stmt = $this->db->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senhaCrip, PDO::PARAM_STR);

        // Executa a consulta
        $stmt->execute();

        // Obtém o resultado da consulta
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dados['quantidade'] > 0) {
            // Salva os dados do usuário na sessão
            $_SESSION['usuario'] = [
                'idUsuario' => $dados['idUsuario'],
                'isAdmin' => $dados['isAdmin'],
                'nomeUsuario' => $dados['nomeUsuario'],
                'emailUsuario' => $dados['emailUsuario']
            ];
            $_SESSION['login_ok'] = true;
            return [
                'success' => true
            ];
        } else {
            // Retorna falha no login
            return [
                'success' => false
            ];
        }
    }

    // Função para verificar se a sessão está ativa
    public function checkSession()
    {
        if (empty($_SESSION['login_ok']) || $_SESSION['login_ok'] === false) {
            header('Location: ../view/login.php?erro=sem_acesso');
            exit();
        }
    }

    // Função para verificar se o usuário é admin
    public function checkAdmin()
    {
        if (empty($_SESSION['usuario']) || $_SESSION['usuario']['isAdmin'] !== 1) {
            $_SESSION['flash_message'] = 'Você não tem permissão para acessar esta página.';
            header('Location: ../view/dashboard.php');
            exit();
        }
    }

    // Função para deslogar o usuário
    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: ../view/login.php');
        exit();
    }
}

// Processar a lógica de login ao receber POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = conectarBanco(); // Conecta ao banco
    $auth = new Auth($db); // Instância da classe Auth

    $email = $_POST['email'] ?? null;
    $senha = $_POST['password'] ?? null;

    // Verifica credenciais
    $resultado = $auth->login($email, $senha);

    if ($resultado['success']) {
        // Redireciona para o dashboard
        header('Location: ../view/dashboard.php');
        exit();
    } else {
        // Redireciona com erro
        $_SESSION['login_ok'] = false;
        header('Location: ../view/login.php?error_auth=s');
        exit();
    }
}
