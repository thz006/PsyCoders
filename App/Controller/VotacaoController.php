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
        case 'delete':
            $id = $_POST['id'] ?? 0;
            if (!$id) {
                throw new Exception('ID da enquete não fornecido.');
            }
    
            if (VotacaoModel::delete($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Enquete excluída com sucesso!']);
            } else {
                throw new Exception('Enquete não encontrada ou não pôde ser excluída.');
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
