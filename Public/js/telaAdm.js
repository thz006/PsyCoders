document.addEventListener('DOMContentLoaded', () => {


    const formProduto = document.querySelector('.formCriarProduto');
    if (formProduto) {
        formProduto.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

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

   
    const btnMostrarMais = document.getElementById('btn-mostrar-mais');
    if (btnMostrarMais) {
        btnMostrarMais.addEventListener('click', () => {
            document.querySelectorAll('.produto-escondido').forEach(linha => {
                linha.style.display = 'table-row';
            });
            btnMostrarMais.style.display = 'none';
        });
    }

   
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
    document.querySelectorAll('.btnExcluirEnquete').forEach(button => {
        button.addEventListener('click', (event) => {
            const id = event.target.dataset.id;
            if (confirm('Tem certeza que deseja excluir esta enquete?')) {
                const formData = new FormData();
                formData.append('id', id);

                fetch('../../App/Controller/VotacaoController.php?action=delete', {
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


    
const formEditarProduto = document.getElementById('formEditarProduto');

if (formEditarProduto) {
    formEditarProduto.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        formData.append('id', formEditarProduto.querySelector('input[name="id"]').value);

        fetch('../../App/Controller/ProdutoController.php?action=update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Produto atualizado com sucesso!');
                window.location.href = 'telaAdm.php'; 
            } else {
                alert('Erro: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            alert('Erro ao atualizar o produto.');
        });
    });
}
 const formEditarEnquete = document.getElementById('formEditarEnquete');


    if (formEditarEnquete) {
        const idEnquete = formEditarEnquete.querySelector('input[name="id"]').value;


        fetch(`../../App/Controller/VotacaoController.php?action=getById&id=${idEnquete}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const enquete = data.enquete;
                    formEditarEnquete.querySelector('#titulo_votacao').value = enquete.titulo;
                    formEditarEnquete.querySelector('#descricao_votacao').value = enquete.descricao;

                    formEditarEnquete.querySelector('#data_inicio').value = enquete.data_inicio.replace(' ', 'T');
                    formEditarEnquete.querySelector('#data_fim').value = enquete.data_fim.replace(' ', 'T');
                    

                    const produtosAssociados = enquete.produtos || [];
                    produtosAssociados.forEach(produtoId => {
                        const checkbox = formEditarEnquete.querySelector(`input[name="produtos[]"][value="${produtoId}"]`);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    });
                } else {
                    alert('Erro: ' + data.message);
                    window.location.href = 'telaAdm.php'; 
                }
            })
            .catch(error => {
                console.error('Erro ao buscar dados da enquete:', error);
                alert('Não foi possível carregar os dados da enquete.');
            });

        formEditarEnquete.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('../../App/Controller/VotacaoController.php?action=update', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Enquete atualizada com sucesso!');
                    window.location.href = 'telaAdm.php';
                } else {
                    alert('Erro: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro na requisição de atualização:', error);
                alert('Ocorreu um erro de comunicação. Tente novamente.');
            });
        });
    }
});

