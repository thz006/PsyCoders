<?php
require_once __DIR__ . '/../../DB/Database.php';

class VotacaoModel {
    public int $id;
    public string $titulo;
    public string $descricao;
    public string $data_inicio;
    public string $data_fim;
    public int $criado_por;
    
    /** @var array IDs dos produtos a serem incluídos na votação */
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
        }
    }

    /**
     * Insere a votação e, em seguida, associa os produtos selecionados.
     */
    public function create(): bool
    {
        $dbVotacoes = new Database('Votacoes');
        
        // Passo 1: Inserir na tabela principal 'Votacoes'
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

        // Passo 2: Inserir as associações na tabela pivo 'votacoes_produtos'
        // Usando o novo método da classe Database
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
}
