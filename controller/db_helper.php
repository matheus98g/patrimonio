<?php
require_once('../model/db.php');

/**
 * Função para buscar dados de uma tabela no banco de dados
 *
 * @param PDO $db Conexão com o banco de dados
 * @param string $table Nome da tabela
 * @param array|null $conditions (Opcional) Condições no formato ['coluna' => 'valor', ...]
 * @return array|false Array de resultados ou false em caso de erro
 */
function get_data($db, $table, $conditions = null)
{
    try {
        // Monta a consulta básica
        $sql = "SELECT * FROM `$table`";
        $params = [];

        // Se houver condições, adiciona na consulta
        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $whereClauses = [];

            foreach ($conditions as $column => $value) {
                $whereClauses[] = "`$column` = :$column";
                $params[":$column"] = $value; // Associando o valor da condição ao parâmetro
            }

            $sql .= implode(" AND ", $whereClauses);
        }

        // Prepara a consulta
        $stmt = $db->prepare($sql);

        // Executa a consulta com os parâmetros
        $stmt->execute($params);

        // Busca os resultados
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    } catch (PDOException $e) {
        // Em caso de erro, registra no log
        error_log($e->getMessage());
        return false;
    }
}
