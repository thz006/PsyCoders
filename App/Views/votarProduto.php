<?php include '../../Public/includes/header.php'; 
	session_start();

    if (!isset($_SESSION['usuario'])) {
    header('Location: telaInicial.php');
    exit();
}
?>


<link rel="stylesheet" href="../../Public/css/swiper-bundle.css">
<script defer src="../../Public/js/swiper-bundle.js"></script>
<script defer src="../../Public/js/votarProduto.js"></script>
<title>Votar Produtos</title>

<body class="votarProduto-body">
	 
	<!-- <div class="votarProduto-Sidebar">

		<div class="votarProduto-logo">
			<img src="../../Public/img/logo.avif" alt="">
			<h1>Buy <span>At</span> Home</h1>
		</div>

		<div class="votarProduto-burguer">
			<i class="fa-solid fa-bars"></i>
		</div>

	</div> -->

	<section class="votarProduto-topSemanal">
		<a href="enquetes.php" class="botao-voltar"><i class="fa-solid fa-angle-left"></i> Voltar</a>

		<div class="votarProduto-topText">
			<h1>Top da Semana</h1>
			<p>Vote e ganhe desconto!</p>
		</div>

		<div class="votarProduto-carousel">
						
			<div class="swiper" id="swiper-inicial">
			  <div class="swiper-wrapper">
			    
			  </div>

			  <div class="swiper-pagination"></div>

			</div>

		</div>

	</section>

	<section class="rankingVotadores">
	  <div class="rankingVotadores-container">
	    <h2>Ranking Mais Votados</h2>
	    <table class="rankingVotadores-tabela">
	      <thead style="display: none;">
	        <tr>
	          <th>Produto</th>
	          <th>Quantidade de Votos</th>
	        </tr>
	      </thead>
	      <tbody>
	        
	      </tbody>
	    </table>
	  </div>
	</section>

</body>