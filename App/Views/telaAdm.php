<?php
include '../../Public/includes/header.php';
?>


<title>Votação</title>


<main class="mainAdm">
    <a href="telaInicial.php" class="botao-voltar"><i class="fa-solid fa-angle-left"></i>Voltar</a>
    <section class="sessaoAddProduto">
        <h1 class="titleAdm">Bem-vindo, Administrador</h1>

        <form class="formCriarProduto" action="" method="">
            <h1>Novo Produto</h1>
            <div class="areaInserirProdutos">
                <label for="">Nome Produto</label>
                <input type="text">
                <label for="">Descrição</label>
                <input type="text">
                <label for="">Imagem do Produto</label>
                <div class="areaImgAdm">
                    <img id="previewImg" src="" alt="">
                </div>
                 <p class="alertAdm">(Favor Inserir uma imagem sem fundo)</p>
                <div class="inserirImgAdm">
                    <input id="imgInput" type="file">
                    <i class="fa-solid fa-plus"></i>
                </div>
            </div>

            <input class="botao-lg" type="submit" value="Salvar">
           
        </form>
       <div class="listaProdutosAdm">
            <h1 class="titleAdm">Produtos Adicionados</h1>

            <div class="tabelaWrapper"> <!-- ADICIONADO AQUI -->
                <table class="tabelaProdutos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Descrição</th>
                            <th>Imagem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Notebook Dell</td>
                            <td>Lindo e bonito</td>
                            <td><img style="max-width: 40px;" src="../../Public/img/image 8.png" alt=""></td>
                            <td>
                                <a href="./editarProduto.php"><button class="btnEditar">Editar</button></a>
                                <a href=""><button class="btnExcluir">Excluir</button></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Fone Bluetooth</td>
                            <td>Áudio</td>
                            <td><img style="max-width: 40px;" src="../../Public/img/image 8.png" alt=""></td>
                            <td>
                                <a href="./editarProduto.php"><button class="btnEditar">Editar</button></a>
                                <a href=""><button class="btnExcluir">Excluir</button></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> <!-- FECHAMENTO DO WRAPPER -->
        </div>

        <p class="descAdm">Abaixo está disponível uma seção destinada à criação de uma enquete, onde é possível adicionar produtos.</p>

        <form class="formCriarVotacao" action="" method="">
            <h1>Nova Enquete</h1>
            <div class="areaInsertVotacoes">
                <label for="">Titulo</label>
                <input type="text">
                <label for="">Descrição</label>
                <input type="text">
                <label for="">Data de Inicio</label>
                <input type="datetime-local">
                <label for="">Data de Fim</label>
                <input type="datetime-local">
                <label for="">Id Produto</label>
                <input type="text">
                <label for="">Id Produto</label>
                <input type="text">
                <label for="">Id Produto</label>
                <input type="text">
                <label for="">Id Produto</label>
                <input type="text">
                <label for="">Id Produto</label>
                <input type="text">
            </div>

            <input class="botao-lg" type="submit" value="Salvar">
        </form>

        <div class="listaEnqueteAdm">
            <h1 class="titleAdm">Enquetes Criadas</h1>
            
            <div class="tabelaWrapper">
                <table class="tabelaEnquete">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th>Data de Início</th>
                            <th>Data de Fim</th>
                            <th>Imagem</th>
                            <th>Nome do Produto</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Promoção Verão</td>
                            <td>Produtos com 30% de desconto</td>
                            <td>2025-07-15 10:00</td>
                            <td>2025-07-20 22:00</td>
                            <td><img style="max-width: 40px;" src="../../Public/img/image 8.png" alt="Produto" class="imgTabela"></td>
                            <td>Chinelo Havaianas</td>
                            <td>
                            <a href="./editarEnquete.php"><button class="btnEditar">Editar</button></a>
                            <a href=""><button class="btnExcluir">Excluir</button></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Lançamento Tech</td>
                            <td>Nova linha de notebooks</td>
                            <td>2025-08-01 09:00</td>
                            <td>2025-08-15 18:00</td>
                            <td><img style="max-width: 40px;" src="../../Public/img/image 8.png" alt="Produto" class="imgTabela"></td>
                            <td>Notebook Ultra Slim</td>
                            <td>
                            <a href="./editarEnquete.php"><button class="btnEditar">Editar</button></a>
                            <a href=""><button class="btnExcluir">Excluir</button></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</main>