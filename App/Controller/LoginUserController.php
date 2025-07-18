<?php
require_once __DIR__ . '/../Model/Usuario.php';
session_start();
header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'));

    if (!$data || empty($data->email) || empty($data->password)) {
        echo json_encode(['success' => false, 'message' => 'Email e senha são obrigatórios.']);
        exit;
    }

    $user = Usuario::findByEmail($data->email);

    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
        exit;
    }

    if (!password_verify($data->password, $user->password)) {
        echo json_encode(['success' => false, 'message' => 'Senha incorreta.']);
        exit;
    }

    $_SESSION['usuario'] = [
    'id' => $user->id,
    'username' => $user->username,
    'email' => $user->email,
    'tipo' => 'usuario' 
    ];

    echo json_encode(['success' => true, 'message' => 'Login de usuário realizado com sucesso!']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no servidor: ' . $e->getMessage()]);
}
