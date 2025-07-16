<?php
require_once __DIR__ . '/../Model/Produto.php';


header('Content-Type: application/json');


$action = $_GET['action'] ?? '';


try {
    switch ($action) {
        case 'create':
            
            $produto = new Produto($_POST);

           
            $produto->criado_por = 1; 

            
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
            if (!$id) {
                throw new Exception('ID do produto não fornecido.');
            }

            if (Produto::delete($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Produto excluído com sucesso!']);
            } else {
                throw new Exception('Produto não encontrado ou não pôde ser excluído.');
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



// $dadosFormulario = $_POST;
            
            // session_start();
            // $dadosFormulario['criado_por'] = $_SESSION['id_funcionario'] ?? 1; 
            
            // if (isset($_FILES['imagem_produto'])) {
            //     $dadosFormulario['imagem_produto'] = $_FILES['imagem_produto'];
            // }

            // $produto = new Produto($_POST);

            // if ($produto->create($_FILES['imagem_produto'] ?? null)) {
            //     echo json_encode(['status' => 'success', 'message' => 'Produto criado com sucesso!']);
            // } else {
            //     throw new Exception('Não foi possível inserir o produto no banco de dados.');
            // }
            // break;