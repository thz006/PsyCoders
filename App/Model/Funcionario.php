<?php
// App/Model/Funcionario.php

require_once __DIR__ . '/../../DB/Database.php';

class Funcionario {
    public ?int $id = null;
    public string $username = '';
    public string $email = '';
    public string $password = ''; // Armazenará o HASH da senha

    public function __construct(array $dados = []) {
        if (!empty($dados)) {
            $this->id       = $dados['id'] ?? null;
            $this->username = $dados['Nome'] ?? '';  // Assumindo que a coluna se chama 'Nome'
            $this->email    = $dados['Email'] ?? ''; // Assumindo que a coluna se chama 'Email'
            $this->password = $dados['Senha'] ?? ''; // Assumindo que a coluna se chama 'Senha'
        }
    }

    /**
     * Encontra um funcionário pelo seu endereço de e-mail.
     *
     * @param string $email O e-mail a ser encontrado.
     * @return self|null Um objeto Funcionario se encontrado, senão null.
     */
     public static function findByEmail(string $email): ?self {
        // --- CORREÇÃO AQUI ---
        // Altere 'funcionarios' para 'Funcionarios' com "F" maiúsculo
        $db = new Database('Funcionarios'); 
        
        try {
            // A busca na coluna 'Email' está correta
            $stmt = $db->select("Email = ?", [htmlspecialchars(strip_tags($email))], null, '1');
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dados ? new self($dados) : null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar funcionário por e-mail: " . $e->getMessage());
            return null;
        }
    }
}