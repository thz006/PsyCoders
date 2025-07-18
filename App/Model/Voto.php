<?php
require_once __DIR__ . '/../../DB/Database.php';

class Voto {
    public int $id_usuario;
    public int $id_produto;
    public int $id_votacoes;

    public function __construct(array $dados) {
        $this->id_usuario = $dados['id_usuario'];
        $this->id_produto = $dados['id_produto'];
        $this->id_votacoes = $dados['id_votacoes'];
    }

    public function registrar(): bool {
        $db = new Database('Votos');
        return $db->insert([
            'id_usuario' => $this->id_usuario,
            'id_produto' => $this->id_produto,
            'id_votacoes' => $this->id_votacoes,
            'data_voto' => date('Y-m-d H:i:s')
        ]);
    }

    public static function jaVotou(int $idUsuario, int $idVotacao): bool {
        $db = new Database('Votos');
        $stmt = $db->select("id_usuario = ? AND id_votacoes = ?", [$idUsuario, $idVotacao]);
        return $stmt->rowCount() > 0;
    }

    public static function rankingPorVotacao(int $idVotacao): array {
        $db = new Database();

        return $db->getRankingVotosPorVotacao($idVotacao);
    }
}
