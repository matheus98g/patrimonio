<?php

// Função para criar a conexão com o banco de dados usando PDO
// function conectarBanco()
// {
//     try {
//         // Parâmetros de conexão
//         $host = 'localhost';
//         $usuario = 'root';
//         $senha = '';
//         $banco = 'patrimonio';

//         // Criação da conexão usando PDO
//         $dsn = "mysql:host=$host;dbname=$banco;charset=utf8";
//         $db = new PDO($dsn, $usuario, $senha);

//         // Configurações PDO para erros
//         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//         // Retorna a conexão com o banco
//         return $db;
//     } catch (PDOException $e) {
//         // Exibe o erro caso ocorra
//         die("Erro na conexão com o banco de dados: " . $e->getMessage());
//     }
// }

// Chama a função para obter a conexão
// $db = conectarBanco();




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
