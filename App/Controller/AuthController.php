<?php

// Inclui os dois Models necessários: User e Funcionario
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/Funcionario.php';

// Define o tipo de conteúdo da resposta como JSON
header('Content-Type: application/json');

// --- Bloco de Ação: REGISTER ---
if (isset($_GET['action']) && $_GET['action'] === 'register') {
    // Verifica se o método da requisição é POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
        exit();
    }

    // Decodifica os dados JSON recebidos
    $data = json_decode(file_get_contents('php://input'));

    // Validações dos dados recebidos
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'JSON inválido.']);
        exit();
    }
    if (empty($data->username) || empty($data->email) || empty($data->password) || empty($data->confirm_password)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
        exit();
    }
    if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'E-mail inválido.']);
        exit();
    }
    // Validação de senha forte
    $senha = $data->password;
    $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':\\\"|,.<>\/?]).{8,}$/";
    if (!preg_match($regex, $senha)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'A senha deve ter pelo menos 8 caracteres, incluindo uma letra maiúscula, uma minúscula, um número e um caractere especial.']);
        exit();
    }
    if ($data->password !== $data->confirm_password) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'As senhas não coincidem.']);
        exit();
    }
    if (User::emailExists($data->email)) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'E-mail já cadastrado.']);
        exit();
    }

    // Tenta criar o usuário
    $result = User::createFromRequest($data);
    if ($result === true) {
        http_response_code(201);
        echo json_encode(['success' => true, 'message' => 'Cadastro realizado com sucesso!']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $result ?: 'Erro ao cadastrar usuário.']);
    }
    exit();
}

// --- Bloco de Ação: LOGIN (com LOGS DETALHADOS PARA DEPURAÇÃO) ---
if (isset($_GET['action']) && $_GET['action'] === 'login') {
    // Validação inicial
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405); echo json_encode(['success' => false, 'message' => 'Método não permitido.']); exit();
    }
    $data = json_decode(file_get_contents('php://input'));
    if (json_last_error() !== JSON_ERROR_NONE || empty($data->email) || empty($data->password)) {
        http_response_code(400); echo json_encode(['success' => false, 'message' => 'E-mail e senha são obrigatórios.']); exit();
    }

    // --- INÍCIO DA DEPURAÇÃO COM LOGS ---

    // 1. Tenta fazer o login como Cliente
    error_log("LOGIN_DEBUG [ETAPA 1]: Verificando CLIENTE com email: " . $data->email);
    $user = User::findByEmail($data->email);
    error_log("LOGIN_DEBUG [ETAPA 1 - RESULTADO]: Objeto User encontrado: " . print_r($user, true));

    if ($user) {
        error_log("LOGIN_DEBUG [ETAPA 2]: Cliente encontrado. Verificando senha...");
        error_log("LOGIN_DEBUG [ETAPA 2 - HASH]: Hash do banco (Cliente): " . $user->password);
        
        if (password_verify($data->password, $user->password)) {
            error_log("LOGIN_DEBUG [SUCESSO]: Senha do CLIENTE verificada. Login bem-sucedido.");
            if (session_status() == PHP_SESSION_NONE) { session_start(); }
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['user_role'] = 'cliente';
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Login realizado com sucesso!', 'redirect' => 'enquete.php']);
            exit();
        } else {
            error_log("LOGIN_DEBUG [FALHA]: Verificação de senha do CLIENTE falhou.");
        }
    }

    // 2. Tenta fazer o login como Funcionário
    error_log("LOGIN_DEBUG [ETAPA 3]: Verificando FUNCIONÁRIO com email: " . $data->email);
    $funcionario = Funcionario::findByEmail($data->email);
    error_log("LOGIN_DEBUG [ETAPA 3 - RESULTADO]: Objeto Funcionario encontrado: " . print_r($funcionario, true));

    if ($funcionario) {
        error_log("LOGIN_DEBUG [ETAPA 4]: Funcionário encontrado. Verificando senha...");
        error_log("LOGIN_DEBUG [ETAPA 4 - HASH]: Hash do banco (Funcionário): " . $funcionario->password);

        if (password_verify($data->password, $funcionario->password)) {
            error_log("LOGIN_DEBUG [SUCESSO]: Senha do FUNCIONÁRIO verificada. Login bem-sucedido.");
            if (session_status() == PHP_SESSION_NONE) { session_start(); }
            $_SESSION['user_id'] = $funcionario->id;
            $_SESSION['username'] = $funcionario->username;
            $_SESSION['user_role'] = 'admin';
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Login de administrador realizado!', 'redirect' => 'telaAdm.php']);
            exit();
        } else {
            error_log("LOGIN_DEBUG [FALHA]: Verificação de senha do FUNCIONÁRIO falhou.");
        }
    }

    // 3. Se ambas as verificações falharam
    error_log("LOGIN_DEBUG [FALHA GERAL]: Nenhum login válido encontrado para o email: " . $data->email);
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'E-mail ou senha incorretos.']);
    exit();
}

// --- Fallback: Ação Inválida ---
// Se o parâmetro 'action' não for 'register' nem 'login', retorna erro.
http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Ação inválida.']);
exit();