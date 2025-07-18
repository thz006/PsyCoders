const localDados = document.getElementById('carregarEnquetes')


document.addEventListener('DOMContentLoaded', () => {
    const alertaRequisicao = document.getElementById('erroRequisicao');
    
   
    async function handleEnquetes() {
        try {
            const responseEnquetes = await fetch('../../App/Controller/BuscarVotacoes.php');
            if (!responseEnquetes.ok) {
                throw new Error('Erro ao buscar enquetes');
            }

            const data = await responseEnquetes.json();
            alertaRequisicao.style.display = "none";
            localDados.innerHTML = "";
           data.forEach(e => {
                const inicio = new Date(e.data_inicio);
                const fim = new Date(e.data_fim);

                const formatador = new Intl.DateTimeFormat('pt-BR', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                const inicioFormatado = formatador.format(inicio);
                const fimFormatado = formatador.format(fim);

                localDados.innerHTML += `
                    <div class="enquete-card">
                        <h1>${e.titulo}</h1>
                        <div class="enquete-info">
                            <p>Do dia ${inicioFormatado} até ${fimFormatado}</p>
                            <a style="text-decoration: none;" href="./votarProduto.php?id=${e.id}">
                                <p style="color: blue;">Clique aqui e veja</p>
                            </a>
                        </div>
                    </div>`;
            });
        } catch (error) {
            console.error('Erro na requisição:', error);
           
            alertaRequisicao.style.display = "flex";
            alertaRequisicao.style.textAlign = "center";
        }
    }

    handleEnquetes();
});


document.addEventListener('DOMContentLoaded', () => {
  const burguer = document.querySelector('.votarProduto-burguer');
  const menu = document.getElementById('menuDropdown');

  burguer.addEventListener('click', () => {
    menu.style.display = menu.style.display === 'flex' ? 'none' : 'flex';
  });


  document.addEventListener('click', function(event) {
    if (!burguer.contains(event.target) && !menu.contains(event.target)) {
      menu.style.display = 'none';
    }
  });
});
