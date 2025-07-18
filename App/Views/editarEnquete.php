<?php
    require_once __DIR__ . '/../../App/Model/Produto.php';
    require_once __DIR__ . '/../../App/Model/Votacao.php';


    session_start();
    if (!isset($_SESSION['funcionario'])) {
    header('Location: telaInicial.php');
    exit();
}


    $id_enquete = $_GET['id'] ?? 0;
    if (!$id_enquete) {

        header('Location: telaAdm.php');
        exit;
    }

    $produtos = Produto::findAll();
    

?>
<?php
    include '../../Public/includes/header.php';
?>

<title>Editar Enquete</title>

<main class="mainAdm">
    <a href="telaAdm.php" class="botao-voltar"><i class="fa-solid fa-angle-left"></i> Voltar</a>
    <section class="sessaoEditEnquete">
        <h1 class="titleAdm">Editar Enquete</h1>

        <form id="formEditarEnquete" class="formEditarEnquete" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id_enquete) ?>">
            
            <div class="areaEditarEnquete">
                <label for="titulo_votacao">Título</label>
                <input type="text" id="titulo_votacao" name="titulo_votacao" required>

                <label for="descricao_votacao">Descrição</label>
                <input type="text" id="descricao_votacao" name="descricao_votacao" required>

                <label for="data_inicio">Data de Início</label>
                <input type="datetime-local" id="data_inicio" name="data_inicio" required>

                <label for="data_fim">Data de Fim</label>
                <input type="datetime-local" id="data_fim" name="data_fim" required>

                <label class="label-produtos">Selecione os Produtos para a Votação:</label>
                <div id="lista-produtos-checkbox" class="lista-produtos-checkbox">
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

            <input class="botao-lg" type="submit" value="Atualizar Enquete">
        </form>
    </section>
</main>
<script src="../../Public/js/telaAdm.js"></script>