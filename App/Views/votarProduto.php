<?php
include '../../Public/includes/header.php';
?>
<link rel="stylesheet" href="../../Public/css/swiper-bundle.css">
<script defer src="../../Public/js/swiper-bundle.js"></script>
<script defer src="../../Public/js/votarProduto.js"></script>
<title>Votar Produtos</title>

<body class="votarProduto-body">
	<div class="votarProduto-Sidebar">

		<div class="votarProduto-logo">
			<img src="../../Public/img/logo.avif" alt="">
			<h1>Buy <span>At</span> Home</h1>
		</div>

		<div class="votarProduto-burguer">
			<i class="fa-solid fa-bars"></i>
		</div>

	</div>

	<section class="votarProduto-topSemanal">

		<div class="votarProduto-topText">
			<h1>Top da Semana</h1>
			<p>Vote e ganhe desconto!</p>
		</div>

		<div class="votarProduto-carousel">
						
			<!-- Slider main container -->
			<div class="swiper" id="swiper-inicial">
			  <!-- Additional required wrapper -->
			  <div class="swiper-wrapper">
			    <!-- Slides -->
			    <div class="swiper-slide">

			    	<div class="votarProduto-Produto">

			    		<img src="../../Public/img/kroCebola.webp" alt="">

			    		<div class="votarProduto-prodInfo">

			    			<div class="votarProduto-prodText">
			    				<h1>Kró Cebola</h1>
			    				<p><span>268</span> votos</p>
			    			</div>

							<i class="fa-solid fa-thumbs-up"></i>

			    		</div>

			    	</div>

			    </div>

			    <div class="swiper-slide">

			    	<div class="votarProduto-Produto">

			    		<img src="../../Public/img/kroCebola.webp" alt="">

			    		<div class="votarProduto-prodInfo">

			    			<div class="votarProduto-prodText">
			    				<h1>Kró Cebola</h1>
			    				<p><span>268</span> votos</p>
			    			</div>

							<i class="fa-solid fa-thumbs-up"></i>

			    		</div>

			    	</div>

			    </div>

			    <div class="swiper-slide">

			    	<div class="votarProduto-Produto">

			    		<img src="../../Public/img/kroCebola.webp" alt="">

			    		<div class="votarProduto-prodInfo">

			    			<div class="votarProduto-prodText">
			    				<h1>Kró Cebola</h1>
			    				<p><span>268</span> votos</p>
			    			</div>

							<i class="fa-solid fa-thumbs-up"></i>

			    		</div>

			    	</div>

			    </div>



			  </div>

			  <!-- If we need pagination -->
			  <div class="swiper-pagination"></div>

			</div>

		</div>

	</section>

</body>