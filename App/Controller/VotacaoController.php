<?php
require_once __DIR__ . '/../Model/Votacao.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'create':
            $dadosFormulario = $_POST;
            $dadosFormulario['criado_por'] = 1; 

            $votacao = new VotacaoModel($dadosFormulario);

            if ($votacao->create()) {
                echo json_encode(['status' => 'success', 'message' => 'Enquete criada com sucesso!']);
            } else {
                throw new Exception('Não foi possível criar a enquete.');
            }
            break;

        default:
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Ação desconhecida.']);
            break;
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
