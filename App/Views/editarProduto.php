<?php

    require_once __DIR__ . '/../../App/Model/Produto.php';
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $produto = null;

    if ($id) {
        $produto = Produto::findById($id);
    }

    if (!$produto) {
        
        echo "<h1>Erro: Produto não encontrado!</h1>";
        echo "<a href='telaAdm.php'>Voltar para a lista de produtos</a>";
        exit;
    }
?>
<?php
    include '../../Public/includes/header.php';
?>

<title>Editar Produto - <?php echo htmlspecialchars($produto->nome); ?></title>

<main class="mainAdm">
    <a href="telaAdm.php" class="botao-voltar"><i class="fa-solid fa-angle-left"></i> Voltar</a>
    
    <section class="sessaoEditProduto">
        <h1 class="titleAdm">Editar Produto</h1>

        <form id="formEditarProduto" method="POST" enctype="multipart/form-data">
            
            
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($produto->id); ?>">

            <div class="areaEditarProduto">
                <label for="nome_produto">Nome Produto</label>
                <input type="text" id="nome_produto" name="nome_produto" value="<?php echo htmlspecialchars($produto->nome); ?>" required>

                <label for="descricao_produto">Descrição</label>
                <input type="text" id="descricao_produto" name="descricao_produto" value="<?php echo htmlspecialchars($produto->descricao); ?>" required>

                <label for="quantidade_produto">Quantidade em Estoque</label>
                <input type="number" id="quantidade_produto" name="quantidade_produto" value="<?php echo htmlspecialchars($produto->quantidade); ?>" min="0" required>

                <label>Imagem Atual</label>
                <div class="areaImgAdm">
                    <?php if (!empty($produto->imagem)): ?>
                        <img id="previewImg" src="../../Public/<?php echo htmlspecialchars($produto->imagem); ?>" alt="Imagem Atual">
                    <?php else: ?>
                        <img id="previewImg" src="" alt="Sem imagem cadastrada">
                    <?php endif; ?>
                </div>

                <p class="alertAdm">(Se desejar alterar, selecione uma nova imagem)</p>
                <div class="inserirImgAdm">
                    <input type="file" name="nova_imagem" id="imgInput" accept="image/*">
                    <i class="fa-solid fa-plus"></i>
                </div>
            </div>

            <input class="botao-lg" type="submit" value="Atualizar Produto">
        </form>
    </section>
</main>
<script src="../../Public/js/telaAdm.js"></script>
