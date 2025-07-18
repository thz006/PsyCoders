<?php

require_once __DIR__ . '/../Model/Usuario.php';
header('Content-Type: application/json; charset=utf-8');

// Garante que é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método inválido.']);
    exit;
}

// Lê o JSON do corpo da requisição
$data = json_decode(file_get_contents('php://input'));

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    exit;
}

$username = trim($data->username ?? '');
$email = trim($data->email ?? '');
$password = $data->password ?? '';
$confirmPassword = $data->confirm_password ?? '';

// Validações básicas
if (!$username || !$email || !$password || !$confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
    exit;
}

// Validação de senha forte
$senhaForteRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
if (!preg_match($senhaForteRegex, $password)) {
    echo json_encode(['success' => false, 'message' => 'A senha deve conter no mínimo 8 caracteres, incluindo: letra maiúscula, minúscula, número e caractere especial.']);
    exit;
}

// Confirmação de senha
if ($password !== $confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'As senhas não coincidem.']);
    exit;
}

// Verifica se e-mail já está cadastrado
if (Usuario::emailExists($email)) {
    echo json_encode(['success' => false, 'message' => 'Este e-mail já está cadastrado.']);
    exit;
}

// Criação do usuário
$result = Usuario::createFromRequest($data);

if ($result === true) {
    echo json_encode(['success' => true, 'message' => 'Usuário cadastrado com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => $result]);
}
