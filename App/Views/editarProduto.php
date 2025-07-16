<?php
include '../../Public/includes/header.php';
?>

<title>Editar Produto</title>

<main class="mainAdm">
    <a href="telaAdm.php" class="botao-voltar"><i class="fa-solid fa-angle-left"></i>Voltar</a>
    <section class="sessaoEditProduto">
         
        <h1 class="titleAdm">Editar Produto</h1>

        <form class="formEditarProduto" action="atualizarProduto.php" method="POST" enctype="multipart/form-data">
            <div class="areaEditarProduto">
                <label for="nomeProduto">Nome Produto</label>
                <input type="text" id="nomeProduto" name="nomeProduto">

                <label for="descricaoProduto">Descrição</label>
                <input type="text" id="descricaoProduto" name="descricaoProduto">

                <label for="imgAtual">Imagem Atual</label>
                <div class="areaImgAdm">
                    <img id="previewImg" src="../../Public/img/image 8.png" alt="Imagem Atual">
                </div>

                <p class="alertAdm">(Se desejar alterar, selecione uma nova imagem sem fundo)</p>
                <div class="inserirImgAdm">
                    <input type="file" name="novaImagem" id="imgInput">
                    <i class="fa-solid fa-plus"></i>
                </div>
            </div>

            <input class="botao-lg" type="submit" value="Atualizar">
        </form>
    </section>
</main>
