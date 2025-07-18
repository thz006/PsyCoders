<?php
require_once __DIR__ . '/../Model/Voto.php';
require_once __DIR__ . '/../Model/Votacao.php';

header('Content-Type: application/json');
session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $input = json_decode(file_get_contents("php://input"), true);

        $idProduto = $input['id_produto'] ?? null;
        $idVotacao = $input['id_votacao'] ?? null;
        $idUsuario = $_SESSION['usuario']['id'] ?? null;

        if (!$idProduto || !$idVotacao || !$idUsuario) {
            throw new Exception('Dados incompletos para votar ou usuário não logado.');
        }

        if (Voto::jaVotou($idUsuario, $idVotacao)) {
            echo json_encode(['error' => 'Você já votou nessa votação.']);
            exit;
        }

        $voto = new Voto([
            'id_usuario' => $idUsuario,
            'id_produto' => $idProduto,
            'id_votacoes' => $idVotacao
        ]);

        $registrou = $voto->registrar();

        if (!$registrou) {
            echo json_encode(['error' => 'Erro ao registrar voto.']);
            exit;
        }


        $produtos = Voto::rankingPorVotacao($idVotacao);

        echo json_encode([
            'success' => true,
            'produtos' => $produtos
        ]);
        exit;

    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $idVotacao = $_GET['id'] ?? null;

        if (!$idVotacao) {
            throw new Exception('ID da votação não fornecido.');
        }

        $votacao = VotacaoModel::findByIdWithProducts((int)$idVotacao);

        if (!$votacao || empty($votacao['produtos'])) {
            throw new Exception('Votação não encontrada ou sem produtos.');
        }


        $produtos = Voto::rankingPorVotacao((int)$idVotacao);

        echo json_encode([
            'votacao' => $votacao,
            'produtos' => $produtos
        ]);
        exit;

    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método HTTP não suportado.']);
        exit;
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
