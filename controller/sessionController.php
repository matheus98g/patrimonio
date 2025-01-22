<?php
require_once('../model/db.php');


class Auth
{
    private $db;

    // Construtor para inicializar a conexão com o banco de dados
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Função de login
    public function login($email, $senha)
    {
        // Criptografa a senha para comparação
        $senhaCrip = base64_encode($senha);

        // Prepara a consulta para evitar injeção de SQL
        $sql = "SELECT COUNT(*) AS quantidade, idUsuario FROM usuario WHERE emailUsuario = :email AND senhaUsuario = :senha";

        // Prepara a consulta PDO
        $stmt = $this->db->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaCrip);

        // Executa a consulta
        $stmt->execute();

        // Obtém o resultado da consulta
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dados['quantidade'] > 0) {
            // Retorna os dados de login com sucesso
            return [
                'success' => true,
                'idUsuario' => $dados['idUsuario']
            ];
        } else {
            // Retorna falha no login
            return [
                'success' => false
            ];
        }
    }

    public function checkSession()
    {
        if (empty($_SESSION['controle_login']) || empty($_SESSION['login_ok']) || $_SESSION['login_ok'] === false) {
            header('Location: ../view/login.php?erro=sem_acesso');
            exit();
        }
    }
}

    // Exemplo de uso da função checkSession
    // $auth = new Auth($db);
    // $auth->checkSession();


// Exemplo de uso
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $email = $_POST['email'];
//     $senha = $_POST['password'];

//     $auth = new Auth($db);
//     $auth->login($email, $senha);
// }
