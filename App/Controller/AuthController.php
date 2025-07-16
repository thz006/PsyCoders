<?php
// App/Controllers/AuthController.php

// Inicia a sessão no início do script para garantir que esteja disponível
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// O caminho para User.php deve ser relativo a AuthController.php
require_once __DIR__ . '/../Models/User.php';

class AuthController {

    public function register() {
        header('Content-Type: application/json'); // Garante que a resposta seja JSON

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método de requisição inválido.']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"));

        // Validação de entrada
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Dados JSON inválidos.']);
            return;
        }

        if (empty($data->username) || empty($data->email) || empty($data->password) || empty($data->confirm_password)) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
            return;
        }

        if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Formato de e-mail inválido.']);
            return;
        }

        if ($data->password !== $data->confirm_password) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'As senhas não coincidem.']);
            return;
        }

        // Verifica se o e-mail já existe
        if (User::emailExists($data->email)) {
            http_response_code(409); // Conflict
            echo json_encode(['success' => false, 'message' => 'Este e-mail já está em uso.']);
            return;
        }

        // Cria um novo objeto User
        $user = new User();
        $user->username = $data->username;
        $user->email = $data->email;
        // Hash da senha antes de atribuir ao objeto e salvar no banco
        $user->password = password_hash($data->password, PASSWORD_DEFAULT);

        try {
            if ($user->create()) {
                http_response_code(201); // Created
                echo json_encode(['success' => true, 'message' => 'Cadastro realizado com sucesso!']);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar usuário.']);
            }
        } catch (\PDOException $e) {
            error_log("Database error during registration: " . $e->getMessage());
            http_response_code(500); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Ocorreu um erro no servidor. Tente novamente mais tarde.']);
        }
    }

    public function login() {
        header('Content-Type: application/json'); // Garante que a resposta seja JSON

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método de requisição inválido.']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"));

        // Validação de entrada
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Dados JSON inválidos.']);
            return;
        }

        if (empty($data->email) || empty($data->password)) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'E-mail e senha são obrigatórios.']);
            return;
        }

        try {
            // Encontra o usuário pelo e-mail
            $user = User::findByEmail($data->email);

            if (!$user || !password_verify($data->password, $user->password)) {
                http_response_code(401); // Unauthorized
                echo json_encode(['success' => false, 'message' => 'E-mail ou senha incorretos.']);
                return;
            }

            // Login bem-sucedido: define variáveis de sessão
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;

            http_response_code(200); // OK
            echo json_encode(['success' => true, 'message' => 'Login realizado com sucesso!', 'redirect' => 'telaInicial.php']);
            
        } catch (\PDOException $e) {
            error_log("Database error during login: " . $e->getMessage());
            http_response_code(500); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Ocorreu um erro no servidor. Tente novamente mais tarde.']);
        }
    }

    public function logout() {
        // Inicia a sessão se ainda não estiver iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_unset(); // Remove todas as variáveis de sessão
        session_destroy(); // Destrói a sessão
        header('Location: telaLogin.php'); // Redireciona para a tela de login
        exit();
    }
}

// Roteamento simples no final do arquivo para lidar com as ações
if (isset($_GET['action'])) {
    $controller = new AuthController();
    $action = $_GET['action'];

    if (method_exists($controller, $action) && (new \ReflectionMethod($controller, $action))->isPublic()) {
        try {
            $controller->$action();
        } catch (Throwable $e) { // Captura qualquer exceção não tratada
            header('Content-Type: application/json');
            http_response_code(500); // Internal Server Error
            error_log("Unhandled exception in AuthController::" . $action . ": " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Ocorreu um erro inesperado no servidor.']);
        }
    } else {
        header('Content-Type: application/json');
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'Ação inválida ou não permitida.']);
    }
    exit(); // Garante que nada mais seja executado após a resposta JSON
}
