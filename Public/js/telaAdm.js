document.addEventListener('DOMContentLoaded', () => {

    // Lógica para o formulário de CRIAR PRODUTO
    const formProduto = document.querySelector('.formCriarProduto');
    if (formProduto) {
        formProduto.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            // O caminho do fetch foi atualizado para corresponder à sua estrutura
            fetch('../../App/Controller/ProdutoController.php?action=create', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Produto criado com sucesso!');
                    window.location.reload();
                } else {
                    alert('Erro: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
                alert('Ocorreu um erro de comunicação. Tente novamente.');
            });
        });
    }

    // Lógica para o formulário de CRIAR VOTAÇÃO (ENQUETE)
    const formVotacao = document.querySelector('.formCriarVotacao');
    if (formVotacao) {
        formVotacao.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('../../App/Controller/VotacaoController.php?action=create', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Enquete criada com sucesso!');
                    window.location.reload();
                } else {
                    alert('Erro: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
                alert('Ocorreu um erro de comunicação. Tente novamente.');
            });
        });
    }

    // Lógica para o botão MOSTRAR MAIS
    const btnMostrarMais = document.getElementById('btn-mostrar-mais');
    if (btnMostrarMais) {
        btnMostrarMais.addEventListener('click', () => {
            document.querySelectorAll('.produto-escondido').forEach(linha => {
                linha.style.display = 'table-row';
            });
            btnMostrarMais.style.display = 'none';
        });
    }

    // Lógica para os botões EXCLUIR
    document.querySelectorAll('.btnExcluir').forEach(button => {
        button.addEventListener('click', (event) => {
            const id = event.target.dataset.id;
            if (confirm('Tem certeza que deseja excluir este produto? A ação não pode ser desfeita.')) {
                const formData = new FormData();
                formData.append('id', id);

                fetch('../../App/Controller/ProdutoController.php?action=delete', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert('Erro: ' + data.message);
                    }
                })
                .catch(error => console.error('Erro na requisição:', error));
            }
        });
    });

    // Lógica para o PREVIEW DA IMAGEM
    const imgInput = document.getElementById('imgInput');
    const previewImg = document.getElementById('previewImg');
    if (imgInput && previewImg) {
        imgInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
