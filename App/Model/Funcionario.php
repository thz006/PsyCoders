<?php
// App/Model/Funcionario.php

require_once __DIR__ . '/../../DB/Database.php';

class Funcionario {
    public ?int $id = null;
    public string $username = '';
    public string $email = '';
    public string $password = '';

    public function __construct(array $dados = []) {
        if (!empty($dados)) {
            $this->id       = $dados['id'] ?? null;
            $this->username = $dados['Nome'] ?? '';  
            $this->email    = $dados['Email'] ?? ''; 
            $this->password = $dados['Senha'] ?? ''; 
        }
    }

    
     public static function findByEmail(string $email): ?self {
        
        $db = new Database('Funcionarios'); 
        
        try {
            
            $stmt = $db->select("Email = ?", [htmlspecialchars(strip_tags($email))], null, '1');
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dados ? new self($dados) : null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar funcionário por e-mail: " . $e->getMessage());
            return null;
        }
    }
}