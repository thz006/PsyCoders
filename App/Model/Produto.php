<?php
require_once __DIR__ . '/../../DB/Database.php';

class Produto {
    public int $id;
    public string $nome;
    public string $descricao;
    public int $quantidade;
    public ?string $imagem = null;
    public string $data_criacao;
    public int $criado_por;

    public function __construct($dados = []) {
        if (!empty($dados)) {
            $this->id           = $dados['id'] ?? 0;
            $this->nome         = $dados['nome_produto'] ?? ($dados['nome'] ?? '');
            $this->descricao    = $dados['descricao_produto'] ?? ($dados['descricao'] ?? '');
            $this->quantidade   = $dados['quantidade_produto'] ?? ($dados['quantidade'] ?? 0);
            $this->criado_por   = $dados['criado_por'] ?? 0;
            
        }
    }

    public function create(?array $arquivoImagem): bool
    {
       
        if (isset($arquivoImagem) && $arquivoImagem['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../Public/img/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $nomeArquivo = uniqid() . '-' . basename($arquivoImagem['name']);
            $caminhoCompleto = $uploadDir . $nomeArquivo;

            if (move_uploaded_file($arquivoImagem['tmp_name'], $caminhoCompleto)) {
                $this->imagem = 'img/' . $nomeArquivo;
            } else {
                $this->imagem = null; 
            }
        } else {
            $this->imagem = null; 
        }

        $db = new Database('Produtos');
        $this->id = $db->insert([
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'quantidade' => $this->quantidade,
            'imagem' => $this->imagem,
            'criado_por' => $this->criado_por,
            'data_criacao' => date('Y-m-d H:i:s')
        ]);

        return $this->id > 0;
    }
    
    public function update(): bool
    {
        $db = new Database('Produtos');
        return $db->update(
            ['nome' => $this->nome, 'descricao' => $this->descricao, 'quantidade' => $this->quantidade],
            "id = ?",
            [$this->id]
        );
    }

    public static function findById(int $id): ?self
    {
        $db = new Database('Produtos');
        $stmt = $db->select("id = ?", [$id]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dados ? new self($dados) : null;
    }

    public static function findAll(): array
    {
        $db = new Database('Produtos');
        return $db->select(null, [], 'nome ASC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete(int $id): bool
    {
        $produto = self::findById($id);
        if ($produto && $produto->imagem) {
            $caminhoArquivo = __DIR__ . '/../../Public/' . $produto->imagem;
            if (file_exists($caminhoArquivo)) {
                unlink($caminhoArquivo);
            }
        }

        $db = new Database('Produtos');
        return $db->delete("id = ?", [$id]);
    }
}
