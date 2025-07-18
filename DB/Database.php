<?php

class Database {
    public ?PDO $conn = null;
    public ?string $table;

    public function __construct(string $table = null) {
        $this->table = $table;
        $this->conecta();
    }

    private function conecta() {
        require_once __DIR__ . '/../Config/db_config.php';
        
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
           
            throw $e;
        }
    }

    public function execute(string $query, array $binds = []): PDOStatement {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($binds);
            return $stmt;
        } catch (PDOException $e) {
           
            throw $e;
        }
    }

    public function insert(array $values): int|false {
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');

        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';
        
        $this->execute($query, array_values($values));
        
        return $this->conn->lastInsertId();
    }
    
    public function update(array $values, string $where, array $where_binds = []): bool {
        $fields = array_keys($values);
        $setClause = implode(' = ?, ', $fields) . ' = ?';
        
        $query = 'UPDATE ' . $this->table . ' SET ' . $setClause . ' WHERE ' . $where;

        $all_binds = array_merge(array_values($values), $where_binds);
        
        $stmt = $this->execute($query, $all_binds);
        return $stmt->rowCount() > 0; 
    }

    public function select(string $where = null, array $binds = [], string $order = null, string $limit = null, string $fields = '*'): PDOStatement {
        $whereClause = $where ? 'WHERE ' . $where : '';
        $orderClause = $order ? 'ORDER BY ' . $order : '';
        $limitClause = $limit ? 'LIMIT ' . $limit : '';

        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' ' . $whereClause . ' ' . $orderClause . ' ' . $limitClause;
        
        return $this->execute($query, $binds);
    }
    public function delete(string $where, array $binds = []): bool {
        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;
        $stmt = $this->execute($query, $binds);
        return $stmt->rowCount() > 0;
    }
    public function insertAndCheck(array $values): bool
    {
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');
        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';
        $stmt = $this->execute($query, array_values($values));
        return $stmt->rowCount() > 0;
    }
    public function selectAllVotacoesComProdutos(): PDOStatement
    {
        $query = "SELECT v.id, v.titulo, v.descricao, v.data_inicio, v.data_fim, 
                         GROUP_CONCAT(p.nome SEPARATOR ', ') as produtos_nomes 
                  FROM Votacoes v 
                  LEFT JOIN votacoes_produtos vp ON v.id = vp.id_votacoes 
                  LEFT JOIN Produtos p ON vp.id_produto = p.id 
                  GROUP BY v.id 
                  ORDER BY v.data_inicio DESC";
        
        return $this->execute($query);
    }
    public function getRankingVotosPorVotacao(int $idVotacao): array {
        $sql = "
            SELECT p.id, p.nome, p.imagem,
                (SELECT COUNT(*) FROM Votos v WHERE v.id_produto = p.id AND v.id_votacoes = ?) AS votos
            FROM Produtos p
            INNER JOIN votacoes_produtos vp ON vp.id_produto = p.id
            WHERE vp.id_votacoes = ?
            ORDER BY votos DESC
        ";
        $stmt = $this->execute($sql, [$idVotacao, $idVotacao]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}