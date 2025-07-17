<?php
// App/Models/User.php

// O caminho para Database.php deve ser relativo a User.php
require_once __DIR__ . '/../../DB/Database.php';

class User {
    public ?int $id = null;
    public string $username = '';
    public string $email = '';
    public string $password = ''; // This will store the HASHED password from the DB
    public ?string $created_at = null; // Assuming your 'users' table has a created_at field

    // Constructor to hydrate the object from database data or initial values
    public function __construct(array $dados = []) {
        if (!empty($dados)) {
            $this->id         = $dados['id'] ?? null;
            $this->username   = $dados['username'] ?? '';
            $this->email      = $dados['email'] ?? '';
            $this->password   = $dados['password'] ?? '';
            $this->created_at = $dados['created_at'] ?? null;
        }
    }

    /**
     * Saves a new user record to the database.
     * Assumes the password property is already hashed before calling this method.
     *
     * @return bool True if the user was created successfully, false otherwise.
     */
    public function create(): bool {
        // Instantiate the Database class for the 'users' table
        $db = new Database('users');

        // Prepare the values for insertion. Sanitize here if not done earlier.
        $values = [
            'username'   => htmlspecialchars(strip_tags($this->username)),
            'email'      => htmlspecialchars(strip_tags($this->email)),
            'password'   => $this->password, // Password should be hashed before reaching here
            'created_at' => date('Y-m-d H:i:s') // Set creation timestamp
        ];

        try {
            // Use the insert method from your Database class
            // The insert method returns the lastInsertId. We assume success if it returns a positive ID.
            $newId = $db->insert($values);

            if ($newId) {
                $this->id = $newId; // Update the object's ID with the newly created one
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erro de banco de dados ao criar usuário: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Updates an existing user record in the database.
     *
     * @return bool True if the user was updated successfully, false otherwise.
     */
    public function update(): bool {
        if (!$this->id) {
            // Cannot update if the ID is not set (i.e., not an existing record)
            return false;
        }

        $db = new Database('users');

        $values = [
            'username' => htmlspecialchars(strip_tags($this->username)),
            'email'    => htmlspecialchars(strip_tags($this->email)),
            // If password needs to be updated, it should be hashed before assigning to $this->password
            'password' => $this->password
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
     * Finds a user by their ID.
     *
     * @param int $id The ID of the user to find.
     * @return self|null A User object if found, null otherwise.
     */
    public static function findById(int $id): ?self {
        $db = new Database('users');
        try {
            $stmt = $db->select("id = ?", [$id], null, '1'); // Limit to 1 result
            $dados = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as associative array
            return $dados ? new self($dados) : null;
        } catch (PDOException $e) {
            error_log("Erro de banco de dados ao buscar usuário por ID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Finds a user by their email address.
     *
     * @param string $email The email address of the user to find.
     * @return self|null A User object if found, null otherwise.
     */
    public static function findByEmail(string $email): ?self {
        $db = new Database('users');
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
     * Checks if a user with the given email already exists in the database.
     *
     * @param string $email The email address to check.
     * @return bool True if the email exists, false otherwise.
     */
    public static function emailExists(string $email): bool {
        $db = new Database('users');
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
     * Deletes a user record from the database by their ID.
     *
     * @param int $id The ID of the user to delete.
     * @return bool True if the user was deleted successfully, false otherwise.
     */
    public static function delete(int $id): bool {
        $db = new Database('users');
        try {
            return $db->delete("id = ?", [$id]);
        } catch (PDOException $e) {
            error_log("Erro de banco de dados ao deletar usuário: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cria um usuário a partir de um objeto de requisição (stdClass)
     * @param object $data
     * @return true|string true em caso de sucesso, mensagem de erro em caso de falha
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
        $db = new Database('users');
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
