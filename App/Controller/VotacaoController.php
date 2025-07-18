<?php
require_once __DIR__ . '/../Model/Votacao.php';
session_start();
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'create':
            $dadosFormulario = $_POST;

            $dadosFormulario['criado_por'] = $_SESSION['funcionario']['id'] ?? null;

            if (!$dadosFormulario['criado_por']) {
                throw new Exception('Funcionário não autenticado.');
            }

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

        case 'getById':
            $id = $_GET['id'] ?? 0;
            if (!$id) {
                throw new Exception('ID da enquete não fornecido.');
            }

            $enquete = VotacaoModel::findByIdWithProducts($id);
            if ($enquete) {
                echo json_encode(['status' => 'success', 'enquete' => $enquete]);
            } else {
                throw new Exception('Enquete não encontrada.');
            }
            break;

        case 'update':
            $dadosFormulario = $_POST;
            if (empty($dadosFormulario['id'])) {
                throw new Exception("ID da enquete é obrigatório para atualização.");
            }

            $dadosFormulario['produtos'] = $dadosFormulario['produtos'] ?? [];

            $votacao = new VotacaoModel($dadosFormulario);

            if ($votacao->update()) {
                echo json_encode(['status' => 'success', 'message' => 'Enquete atualizada com sucesso!']);
            } else {
                throw new Exception('Não foi possível atualizar a enquete.');
            }
            break;
        
        case 'getProdutos':
    $id = $_GET['id'] ?? 0;

    if (!$id) {
        throw new Exception('ID da votação não fornecido.');
    }

    $votacao = VotacaoModel::findByIdWithProducts($id);

    if (!$votacao || empty($votacao['produtos'])) {
        echo json_encode(['status' => 'success', 'produtos' => []]);
        exit;
    }

    $produtos = [];

    foreach ($votacao['produtos'] as $id_produto) {
        $dbProduto = new Database('Produtos');
        $produto = $dbProduto->select('id = ?', [$id_produto])->fetch(PDO::FETCH_ASSOC);

        if ($produto) {

            $dbVotos = new Database('Votos');
            $contagem = $dbVotos->count('id_produto = ? AND id_votacoes = ?', [$id_produto, $id]);

            $produtos[] = [
                'id' => $produto['id'],
                'nome' => $produto['nome'],
                'descricao' => $produto['descricao'],
                'imagem' => $produto['imagem'],
                'votos' => $contagem
            ];
        }
    }

    echo json_encode([
        'status' => 'success',
        'votacao' => [
            'id' => $id,
            'titulo' => $votacao['titulo'] ?? '',
            'descricao' => $votacao['descricao'] ?? ''
        ],
        'produtos' => $produtos
    ]);
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
