<?php

require_once __DIR__ . '/../../DB/Database.php';

class Usuario {
    public ?int $id = null;
    public string $username = '';
    public string $email = '';
    public string $password = ''; 
    public ?string $created_at = null; 

    public function __construct(array $dados = []) {
    if (!empty($dados)) {
        $this->id         = $dados['id'] ?? null;
        $this->username   = $dados['Nome'] ?? '';     
        $this->email      = $dados['Email'] ?? '';    
        $this->password   = $dados['Senha'] ?? '';   
        $this->created_at = $dados['created_at'] ?? null; 
    }
}

    /**
     * @return bool
     */
    public function create(): bool {
        $db = new Database('Usuario');

        $values = [
            'Nome'   => htmlspecialchars(strip_tags($this->username)),
            'Email'      => htmlspecialchars(strip_tags($this->email)),
            'Senha'   => $this->password, 
        ];

        try {
            $newId = $db->insert($values);

            if ($newId) {
                $this->id = $newId; 
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erro de banco de dados ao criar usuário: " . $e->getMessage());
            return false;
        }
    }

    /**
     * @return bool 
     */
    public function update(): bool {
        if (!$this->id) {
            
            return false;
        }

        $db = new Database('Usuario');

        $values = [
            'Nome' => htmlspecialchars(strip_tags($this->username)),
            'Email'    => htmlspecialchars(strip_tags($this->email)),
            'Senha' => $this->password
        ];

        try {
            return $db->update(
                $values,
                "id = ?",
                [$this->id]
            );
        } catch (PDOException $e) {
            error_log("Erro de banco de dados ao atualizar usuário: " . $e->getMessage());
            return false;
        }
    }

    /**
     * @param int 
     * @return self|null
     */
    public static function findById(int $id): ?self {
        $db = new Database('Usuario');
        try {
            $stmt = $db->select("id = ?", [$id], null, '1'); 
            $dados = $stmt->fetch(PDO::FETCH_ASSOC); 
            return $dados ? new self($dados) : null;
        } catch (PDOException $e) {
            error_log("Erro de banco de dados ao buscar usuário por ID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * @param string 
     * @return self|null
     */
    public static function findByEmail(string $email): ?self {
        $db = new Database('Usuario');
        try {
            $stmt = $db->select("email = ?", [htmlspecialchars(strip_tags($email))], null, '1');
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dados ? new self($dados) : null;
        } catch (PDOException $e) {
            error_log("Erro de banco de dados ao buscar usuário por e-mail: " . $e->getMessage());
            return null;
        }
    }

    /**
     * @param string $email The email address to check.
     * @return bool True if the email exists, false otherwise.
     */
    public static function emailExists(string $email): bool {
        $db = new Database('Usuario');
        try {
            $stmt = $db->select("email = ?", [htmlspecialchars(strip_tags($email))], null, null, 'COUNT(*) as count');
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['count'] > 0;
        } catch (PDOException $e) {
            error_log("Erro de banco de dados ao verificar existência de e-mail: " . $e->getMessage());
            return false;
        }
    }

    /**
     * @param int $id The ID of the user to delete.
     * @return bool True if the user was deleted successfully, false otherwise.
     */
    public static function delete(int $id): bool {
        $db = new Database('Usuario');
        try {
            return $db->delete("id = ?", [$id]);
        } catch (PDOException $e) {
            error_log("Erro de banco de dados ao deletar usuário: " . $e->getMessage());
            return false;
        }
    }

    /**
     * @param object 
     * @return true|string
     */
    public static function createFromRequest($data) {
        try {
            $user = new self();
            $user->username = $data->username;
            $user->email = $data->email;
            $user->password = password_hash($data->password, PASSWORD_DEFAULT);
            if ($user->create()) {
                return true;
            } else {
                return 'Erro ao inserir usuário no banco.';
            }
        } catch (\Throwable $e) {
            error_log('Erro ao criar usuário: ' . $e->getMessage());
            return 'Erro inesperado: ' . $e->getMessage();
        }
    }

    public static function getUser(int $id): ?array {
        $db = new Database('Usuario');
        try {
            $stmt = $db->select("id = ?", [$id], null, '1');
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dados ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar cliente: " . $e->getMessage());
            return null;
        }
    }
}
