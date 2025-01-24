<?php

// Função para criar a conexão com o banco de dados usando PDO
function conectarBanco()
{
    // Parâmetros de conexão
    $host = 'localhost';
    $usuario = 'root';
    $senha = '';
    $banco = 'patrimonio';

    try {
        // Criação da conexão PDO
        $db = new PDO("mysql:host=$host;dbname=$banco", $usuario, $senha);
        // var_dump($db);
        // exit();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        // Exibe o erro detalhado, caso ocorra
        die("Erro na conexão com o banco de dados: " . $e->getMessage());
    }
}
