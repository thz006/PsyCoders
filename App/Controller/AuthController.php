<?php
// App/Controller/AuthController.php

require_once __DIR__ . '/../Model/User.php';

header('Content-Type: application/json');

if (isset($_GET['action']) && $_GET['action'] === 'register') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
        exit();
    }
    $data = json_decode(file_get_contents('php://input'));
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

if (isset($_GET['action']) && $_GET['action'] === 'login') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
        exit();
    }
    $data = json_decode(file_get_contents('php://input'));
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'JSON inválido.']);
        exit();
    }
    if (empty($data->email) || empty($data->password)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'E-mail e senha são obrigatórios.']);
        exit();
    }
    $user = User::findByEmail($data->email);
    if (!$user || !password_verify($data->password, $user->password)) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'E-mail ou senha incorretos.']);
        exit();
    }
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['user_id'] = $user->id;
    $_SESSION['username'] = $user->username;
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Login realizado com sucesso!', 'redirect' => 'telaInicial.php']);
    exit();
}

http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Ação inválida.']);
exit(); 