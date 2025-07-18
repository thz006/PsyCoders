<?php

require_once __DIR__ . '/../Model/Usuario.php';
header('Content-Type: application/json; charset=utf-8');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método inválido.']);
    exit;
}


$data = json_decode(file_get_contents('php://input'));

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    exit;
}

$username = trim($data->username ?? '');
$email = trim($data->email ?? '');
$password = $data->password ?? '';
$confirmPassword = $data->confirm_password ?? '';


if (!$username || !$email || !$password || !$confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
    exit;
}


$senhaForteRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
if (!preg_match($senhaForteRegex, $password)) {
    echo json_encode(['success' => false, 'message' => 'A senha deve conter no mínimo 8 caracteres, incluindo: letra maiúscula, minúscula, número e caractere especial.']);
    exit;
}


if ($password !== $confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'As senhas não coincidem.']);
    exit;
}


if (Usuario::emailExists($email)) {
    echo json_encode(['success' => false, 'message' => 'Este e-mail já está cadastrado.']);
    exit;
}


$result = Usuario::createFromRequest($data);

if ($result === true) {
    echo json_encode(['success' => true, 'message' => 'Usuário cadastrado com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => $result]);
}
