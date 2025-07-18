<?php
require_once __DIR__ . '/../Model/Produto.php';
session_start();
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'create':
            $dadosFormulario = $_POST;

            // Pega o ID do funcionário logado pela session
            $dadosFormulario['criado_por'] = $_SESSION['funcionario']['id'] ?? null;

            if (!$dadosFormulario['criado_por']) {
                throw new Exception('Usuário não autenticado.');
            }

            // Adiciona a imagem ao array, se existir
            if (isset($_FILES['imagem_produto'])) {
                $dadosFormulario['imagem_produto'] = $_FILES['imagem_produto'];
            }

            // Cria o objeto Produto com os dados
            $produto = new Produto($dadosFormulario);

            if ($produto->create($_FILES['imagem_produto'] ?? null)) {
                echo json_encode(['status' => 'success', 'message' => 'Produto criado com sucesso!']);
            } else {
                throw new Exception('Não foi possível inserir o produto no banco de dados.');
            }
            break;

        case 'readAll':
            $produtos = Produto::findAll();
            echo json_encode(['status' => 'success', 'data' => $produtos]);
            break;

        case 'delete':
            $id = $_POST['id'] ?? 0;
            if (!$id) throw new Exception('ID do produto não fornecido.');

            if (Produto::delete($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Produto excluído com sucesso!']);
            } else {
                throw new Exception('Produto não encontrado ou não pôde ser excluído.');
            }
            break;

        case 'update':
            $id = $_POST['id'] ?? null;
            if (!$id) throw new Exception('ID do produto não fornecido.');

            $produto = Produto::findById($id);
            if (!$produto) throw new Exception('Produto não encontrado.');

            $dadosAtualizados = [
                'nome_produto' => $_POST['nome_produto'] ?? '',
                'descricao_produto' => $_POST['descricao_produto'] ?? '',
                'quantidade_produto' => $_POST['quantidade_produto'] ?? 0
            ];

            $novaImagem = $_FILES['nova_imagem'] ?? null;

            if ($produto->update($dadosAtualizados, $novaImagem)) {
                echo json_encode(['status' => 'success', 'message' => 'Produto atualizado com sucesso!']);
            } else {
                throw new Exception('Erro ao atualizar o produto.');
            }
            break;

        default:
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Ação desconhecida.']);
            break;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
