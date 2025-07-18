<?php
require_once __DIR__ . '/../../DB/Database.php';

class VotacaoModel {
    public int $id;
    public string $titulo;
    public string $descricao;
    public string $data_inicio;
    public string $data_fim;
    public int $criado_por;
    
    public array $produtos = [];

    public function __construct($dados = []) {
        if (!empty($dados)) {
            $this->id          = $dados['id'] ?? 0;
            $this->titulo      = $dados['titulo_votacao'] ?? '';
            $this->descricao   = $dados['descricao_votacao'] ?? '';
            $this->data_inicio = $dados['data_inicio'] ?? '';
            $this->data_fim    = $dados['data_fim'] ?? '';
            $this->produtos    = $dados['produtos'] ?? [];
            $this->criado_por  = $dados['criado_por'] ?? 0;


         if (!empty($dados['data_inicio'])) {
            $this->data_inicio = str_replace('T', ' ', $dados['data_inicio']) . ':00';
        } else {
            $this->data_inicio = '';
        }

        if (!empty($dados['data_fim'])) {
            $this->data_fim = str_replace('T', ' ', $dados['data_fim']) . ':00';
        } else {
            $this->data_fim = '';
        }
        }
    }

    public function create(): bool
    {
        $dbVotacoes = new Database('Votacoes');

        $this->id = $dbVotacoes->insert([
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'data_inicio' => $this->data_inicio,
            'data_fim' => $this->data_fim,
            'criado_por' => $this->criado_por
        ]);

        if (!$this->id) {
            return false;
        }

        if (empty($this->produtos)) {
            return true;
        }


        $dbVotacoesProdutos = new Database('votacoes_produtos');
        $sucesso = true;
        
        foreach ($this->produtos as $id_produto) {
            $resultado = $dbVotacoesProdutos->insertAndCheck([
                'id_votacoes' => $this->id,
                'id_produto' => (int)$id_produto
            ]);
            
            if (!$resultado) {
                $sucesso = false;
            }
        }
        
        return $sucesso;
    }
    public static function findAllWithProducts(): array
    {
        $db = new Database(); 
        $stmt = $db->selectAllVotacoesComProdutos(); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete(int $id): bool
    {
        $db = new Database('Votacoes');
        return $db->delete("id = ?", [$id]);
    }
      public function update(): bool
    {

        $dbVotacoes = new Database('Votacoes');
        $sucesso_update = $dbVotacoes->update([
            'titulo'      => $this->titulo,
            'descricao'   => $this->descricao,
            'data_inicio' => $this->data_inicio,
            'data_fim'    => $this->data_fim,
        ], "id = ?", [$this->id]);

        if (!$sucesso_update) {

            error_log("ERRO (VotacaoModel): Falha ao atualizar a tabela 'Votacoes' para o ID: " . $this->id);
            return false;
        }

        $dbVotacoesProdutos = new Database('votacoes_produtos');

        $sucesso_delete = $dbVotacoesProdutos->delete('id_votacoes = ?', [$this->id]);

        if ($sucesso_delete === false) {
            error_log("ERRO (VotacaoModel): Falha ao executar DELETE em 'votacoes_produtos' para o id_votacoes: " . $this->id);
            return false;
        }
        if (empty($this->produtos)) {
            return true;
        }

        foreach ($this->produtos as $id_produto) {
            $resultado_insert = $dbVotacoesProdutos->insertAndCheck([
                'id_votacoes' => $this->id,
                'id_produto'  => (int)$id_produto
            ]);

            if (!$resultado_insert) {
                error_log("ERRO (VotacaoModel): Falha ao inserir associação para id_votacoes: {$this->id} e id_produto: {$id_produto}. Verifique chaves estrangeiras.");
                return false; 
            }
        }

        return true;
    }


    public static function findByIdWithProducts(int $id): ?array
    {

        $db = new Database('Votacoes');
        $votacao = $db->select("id = ?", [$id])->fetch(PDO::FETCH_ASSOC);

        if (!$votacao) {
            return null;
        }


        $dbProdutos = new Database('votacoes_produtos');
        $produtosStmt = $dbProdutos->select("id_votacoes = ?", [$id]);
        $produtosIds = $produtosStmt->fetchAll(PDO::FETCH_COLUMN, 1); 

        $votacao['produtos'] = $produtosIds;

        return $votacao;
    }

    public static function getAllEnquetes(): array
{
    $db = new Database('Votacoes');
    $resultados = $db->select()->fetchAll(PDO::FETCH_ASSOC);
    $votacoes = [];

    foreach ($resultados as $dados) {
        
        $dbVotacoesProdutos = new Database('votacoes_produtos');
        $produtos = $dbVotacoesProdutos
            ->select('id_votacoes = ' . $dados['id'])
            ->fetchAll(PDO::FETCH_COLUMN, 1);

        $dados['produtos'] = $produtos;

  
        $votacoes[] = $dados;
    }

    return $votacoes;
}
}
