document.addEventListener('DOMContentLoaded', async () => {
  try {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    const response = await fetch(`/PsyCoders/App/Controller/VotarController.php?id=${id}`);
    const data = await response.json();

    if (data.error) {
      console.error(data.error);
      return;
    }

    const swiperWrapper = document.querySelector('.swiper-wrapper');
    const rankingBody = document.querySelector('.rankingVotadores-tabela tbody');
    swiperWrapper.innerHTML = '';
    rankingBody.innerHTML = '';

    function montarSlidesEranking(produtos) {
      swiperWrapper.innerHTML = '';
      rankingBody.innerHTML = '';

      produtos.forEach(produto => {
        // Slide
        const slide = document.createElement('div');
        slide.classList.add('swiper-slide');
        slide.innerHTML = `
          <div class="votarProduto-Produto">
            <img src="../../Public/${produto.imagem}" alt="${produto.nome}">
            <div class="votarProduto-prodInfo">
              <div class="votarProduto-prodText">
                <h1>${produto.nome}</h1>
                <p><span class="voto-count">${produto.votos}</span> votos</p>
              </div>
              <i class="fa-solid fa-thumbs-up votar-btn" data-id-produto="${produto.id}" data-id-votacao="${data.votacao.id}"></i>
            </div>
          </div>
        `;
        swiperWrapper.appendChild(slide);

        // Ranking
        const row = document.createElement('tr');
        row.innerHTML = `
          <td class="td1">${produto.nome}</td>
          <td class="td2">${produto.votos} votos</td>
        `;
        rankingBody.appendChild(row);
      });
    }

    montarSlidesEranking(data.produtos);

    // Inicializa Swiper
    const swiper = new Swiper('#swiper-inicial', {
      slidesPerView: 'auto',
      centeredSlides: true,
      spaceBetween: 50,
      grabCursor: true,
      initialSlide: 1,
      pagination: { el: '.swiper-pagination', clickable: true },
      breakpoints: {
        768: { slidesPerView: 3, spaceBetween: 24 }
      }
    });

    // Função para adicionar evento de voto em todos botões
    function ativarEventosDeVoto() {
      document.querySelectorAll('.votar-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
          const idProduto = btn.dataset.idProduto;
          const idVotacao = btn.dataset.idVotacao;

          try {
            const res = await fetch('/PsyCoders/App/Controller/VotarController.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ id_produto: idProduto, id_votacao: idVotacao })
            });

            const resData = await res.json();

            if (resData.success) {
              // Atualiza slides e ranking com dados atualizados do servidor
              montarSlidesEranking(resData.produtos);
              swiper.update(); // Atualiza swiper para reconhecer os novos slides

              // Reativar eventos de voto nos novos botões
              ativarEventosDeVoto();

            } else {
              alert(resData.error || 'Você já votou!');
            }

          } catch (e) {
            console.error('Erro ao votar:', e);
          }
        });
      });
    }

    ativarEventosDeVoto();

  } catch (error) {
    console.error('Erro ao carregar produtos:', error);
  }
});
