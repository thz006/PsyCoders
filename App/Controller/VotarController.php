<?php
require_once __DIR__ . '/../../DB/Database.php';
session_start();

header('Content-Type: application/json');

try {
    // POST: Votar
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents("php://input"), true);
        $idProduto = $input['id_produto'] ?? null;
        $idVotacao = $input['id_votacao'] ?? null;
        $idUsuario = $_SESSION['user_id'] ?? null;

        if (!$idProduto || !$idVotacao || !$idUsuario) {
            http_response_code(400);
            echo json_encode(["error" => "Dados incompletos para votar ou usuário não logado."]);
            exit;
        }

        $db = new Database('Votos');
        $existe = $db->select("id_usuario = ? AND id_votacoes = ?", [$idUsuario, $idVotacao]);

        if ($existe->rowCount() > 0) {
            echo json_encode(["error" => "Você já votou nessa votação."]);
            exit;
        }

        $voto = [
            'id_votacoes' => $idVotacao,
            'id_produto' => $idProduto,
            'id_usuario' => $idUsuario
        ];

        $db->insert($voto);

        // Retornar os dados atualizados da votação
        $dbProdutos = new Database('Produtos');
        $query = "
            SELECT p.id, p.nome, p.imagem,
                (SELECT COUNT(*) FROM Votos v WHERE v.id_produto = p.id AND v.id_votacoes = ?) as votos
            FROM Produtos p
            INNER JOIN votacoes_produtos vp ON vp.id_produto = p.id
            WHERE vp.id_votacoes = ?
            ORDER BY votos DESC
        ";
        $stmt = $dbProdutos->execute($query, [$idVotacao, $idVotacao]);
        $produtos = $stmt->fetchAll();

        echo json_encode([
            "success" => true,
            "produtos" => $produtos
        ]);
        exit;
    }

    // GET: Buscar dados da votação
    $idVotacao = $_GET['id'] ?? null; // ← trocado de 'id_votacao' para 'id'

    $db = new Database('Votacoes');

    if ($idVotacao) {
        $stmt = $db->select("id = ?", [$idVotacao]);
        $votacao = $stmt->fetch();

        if (!$votacao) {
            echo json_encode(["error" => "Votação não encontrada."]);
            exit;
        }
    } else {
        $stmt = $db->select("data_inicio <= NOW() AND data_fim >= NOW()", [], "id DESC", "1");
        $votacao = $stmt->fetch();

        if (!$votacao) {
            echo json_encode(["error" => "Nenhuma votação ativa."]);
            exit;
        }

        $idVotacao = $votacao['id'];
    }

    $dbProdutos = new Database('Produtos');
    $query = "
        SELECT p.id, p.nome, p.imagem,
            (SELECT COUNT(*) FROM Votos v WHERE v.id_produto = p.id AND v.id_votacoes = ?) as votos
        FROM Produtos p
        INNER JOIN votacoes_produtos vp ON vp.id_produto = p.id
        WHERE vp.id_votacoes = ?
        ORDER BY votos DESC
    ";
    $stmt = $dbProdutos->execute($query, [$idVotacao, $idVotacao]);
    $produtos = $stmt->fetchAll();

    echo json_encode([
        'votacao' => $votacao,
        'produtos' => $produtos
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
