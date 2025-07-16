<?php
include '../../Public/includes/header.php';
?>

<title>Editar Enquete</title>

<main class="mainAdm">
    <a href="telaAdm.php" class="botao-voltar"><i class="fa-solid fa-angle-left"></i>Voltar</a>
    <section class="sessaoEditEnquete">
        <h1 class="titleAdm">Editar Enquete</h1>

        <form class="formEditarEnquete" action="atualizarEnquete.php" method="POST" enctype="multipart/form-data">
            <div class="areaEditarEnquete">
                <label for="tituloEnquete">Título</label>
                <input type="text" id="tituloEnquete" name="tituloEnquete">

                <label for="descricaoEnquete">Descrição</label>
                <input type="text" id="descricaoEnquete" name="descricaoEnquete">

                <label for="dataInicio">Data de Início</label>
                <input type="datetime-local" id="dataInicio" name="dataInicio">

                <label for="dataFim">Data de Fim</label>
                <input type="datetime-local" id="dataFim" name="dataFim">

                <label for="imgAtualEnquete">Imagem do Produto</label>
                <div class="areaImgAdm">
                    <img id="previewImg" src="" alt="Imagem do Produto">
                </div>

                <p class="alertAdm">(Se desejar alterar, selecione uma nova imagem sem fundo)</p>
                <div class="inserirImgAdm">
                    <input type="file" name="novaImagemEnquete" id="imgInput">
                    <i class="fa-solid fa-plus"></i>
                </div>

                <label for="nomeProduto">Nome do Produto</label>
                <input type="text" id="nomeProduto" name="nomeProduto">
            </div>

            <input class="botao-lg" type="submit" value="Atualizar">
        </form>
    </section>
</main>
