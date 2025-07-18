<?php
require_once __DIR__ . '/../Model/Funcionario.php';
session_start();
header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'));

    if (!$data || empty($data->email) || empty($data->password)) {
        echo json_encode(['success' => false, 'message' => 'Email e senha são obrigatórios.']);
        exit;
    }

    $func = Funcionario::findByEmail($data->email);

    if (!$func) {
        echo json_encode(['success' => false, 'message' => 'Funcionário não encontrado.']);
        exit;
    }

    if ($data->password !== $func->password) {
        echo json_encode(['success' => false, 'message' => 'Senha incorreta.']);
        exit;
    }

    $_SESSION['funcionario'] = [
        'id' => $func->id,
        'username' => $func->username,
        'email' => $func->email,
        'tipo' => 'funcionario' 
    ];

    echo json_encode(['success' => true, 'message' => 'Login de funcionário realizado com sucesso!']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no servidor: ' . $e->getMessage()]);
}
