<?php
    require_once __DIR__ . '/../../App/Model/Produto.php';
    require_once __DIR__ . '/../../App/Model/Votacao.php';
    $produtos = Produto::findAll();
    $votacoes = VotacaoModel::findAllWithProducts();
    session_start();
//         if (!isset($_SESSION['user_id'])) {
//     header('Location: telaInicial.php');
//     exit();
// }
?>


<?php
    include '../../Public/includes/header.php';
?>

<title>Votação - Administração</title>

<main class="mainAdm">
    <a href="../Controller/logout.php" class="botao-voltar"><i class="fa-solid fa-angle-left"></i> Voltar</a>
    
    <section class="sessaoAddProduto">
        <h1 class="titleAdm">Bem-vindo, Administrador</h1>

        <form class="formCriarProduto" method="POST" enctype="multipart/form-data">
            <h1>Novo Produto</h1>
            <div class="areaInserirProdutos">
                <label for="nome_produto">Nome Produto</label>
                <input type="text" id="nome_produto" name="nome_produto" required>

                <label for="descricao_produto">Descrição</label>
                <input type="text" id="descricao_produto" name="descricao_produto" required>

                <label for="quantidade_produto">Quantidade em Estoque</label>
                <input type="number" id="quantidade_produto" name="quantidade_produto" min="0" required>

                <label for="imgInput">Imagem do Produto</label>
                <div class="areaImgAdm">
                    <img id="previewImg" src="" alt="Pré-visualização da imagem">
                </div>
                <p class="alertAdm">(Favor Inserir uma imagem sem fundo)</p>
                <div class="inserirImgAdm">
                    <input id="imgInput" name="imagem_produto" type="file" accept="image/*" required>
                    <i class="fa-solid fa-plus"></i>
                </div>
            </div>
            <input class="botao-lg" type="submit" value="Salvar Produto">
        </form>

        <div class="listaProdutosAdm">
            <h1 class="titleAdm">Produtos Adicionados</h1>
            <div class="tabelaWrapper">
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
                        <?php
                            if (!empty($produtos)) {
                                $contador = 0;
                                foreach ($produtos as $produto) {
                                    $contador++;
                                    $classe_css = ($contador > 3) ? 'class="produto-escondido"' : '';
                                    echo "<tr {$classe_css}>";
                                    echo "<td>" . htmlspecialchars($produto['id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($produto['nome']) . "</td>";
                                    echo "<td>" . htmlspecialchars($produto['descricao']) . "</td>";
                                    echo "<td>";
                                    if (!empty($produto['imagem'])) {
                                        echo "<img style='max-width: 40px; border-radius: 4px;' src='../../Public/" . htmlspecialchars($produto['imagem']) . "' alt='" . htmlspecialchars($produto['nome']) . "'>";
                                    } else {
                                        echo "<span style='font-size: 12px; color: #888;'>Sem Imagem</span>";
                                    }
                                    echo "</td>";
                                    echo "<td>";
                                    echo "<a href='./editarProduto.php?id=" . htmlspecialchars($produto['id']) . "'><button class='btnEditar'>Editar</button></a>";
                                    echo "<button class='btnExcluir' data-id='" . htmlspecialchars($produto['id']) . "'>Excluir</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo '<tr><td colspan="5" style="text-align:center; padding: 20px;">Nenhum produto cadastrado ainda.</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
                if (count($produtos) > 3) {
                    echo "<button id='btn-mostrar-mais' class='botao-lg' style='margin-top: 20px;'>Mostrar mais</button>";
                }
            ?>
        </div>

        <p class="descAdm" style="margin-top: 50px;">Abaixo está disponível uma seção destinada à criação de uma enquete, onde é possível adicionar produtos.</p>

        <form class="formCriarVotacao" method="POST">
            <h1>Nova Enquete</h1>
            <div class="areaInsertVotacoes">
                <label for="titulo_votacao">Título</label>
                <input type="text" id="titulo_votacao" name="titulo_votacao" required>

                <label for="descricao_votacao">Descrição</label>
                <input type="text" id="descricao_votacao" name="descricao_votacao" required>

                <label for="data_inicio">Data de Início</label>
                <input type="datetime-local" id="data_inicio" name="data_inicio" required>

                <label for="data_fim">Data de Fim</label>
                <input type="datetime-local" id="data_fim" name="data_fim" required>

                <label class="label-produtos">Selecione os Produtos para a Votação:</label>
                <div class="lista-produtos-checkbox">
                    <?php
                        if (!empty($produtos)) {
                            foreach ($produtos as $produto) {
                                echo '<div class="produto-checkbox">';
                                echo '<input type="checkbox" name="produtos[]" value="' . htmlspecialchars($produto['id']) . '" id="produto_' . htmlspecialchars($produto['id']) . '">';
                                echo '<label for="produto_' . htmlspecialchars($produto['id']) . '">' . htmlspecialchars($produto['nome']) . '</label>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="sem-produtos">Nenhum produto disponível para seleção.</p>';
                        }
                    ?>
                </div>
            </div>
            <input class="botao-lg" type="submit" value="Salvar Enquete">
        </form>

        <div class="listaEnqueteAdm" style="margin-top: 30px;">
            <h1 class="titleAdm">Enquetes Criadas</h1>
            <div class="tabelaWrapper">
                <table class="tabelaEnquete">
                    <thead>
                        <tr>
                            <th>Título</th><th>Descrição</th><th>Início</th><th>Fim</th><th>Produtos na Votação</th><th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php
                            if (!empty($votacoes)) {
                                foreach ($votacoes as $votacao) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($votacao['titulo']) . "</td>";
                                    echo "<td>" . htmlspecialchars($votacao['descricao']) . "</td>";
                                    echo "<td>" . htmlspecialchars(date('d/m/Y H:i', strtotime($votacao['data_inicio']))) . "</td>";
                                    echo "<td>" . htmlspecialchars(date('d/m/Y H:i', strtotime($votacao['data_fim']))) . "</td>";
                                    echo "<td>" . htmlspecialchars($votacao['produtos_nomes'] ?? 'Nenhum produto associado') . "</td>";
                                    echo "<td>";
                                    echo "<a href='./editarEnquete.php?id=" . htmlspecialchars($votacao['id']) . "'><button class='btnEditar'>Editar</button></a>";
                                    echo "<button class='btnExcluirEnquete' data-id='" . htmlspecialchars($votacao['id']) . "'>Excluir</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo '<tr><td colspan="6" style="text-align:center; padding: 20px;">Nenhuma enquete criada ainda.</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
<script src="../../Public/js/telaAdm.js"></script>
