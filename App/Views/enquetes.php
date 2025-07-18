<?php include '../../Public/includes/header.php';
include '../../App/Model/Usuario.php'; 
session_start();


if (!isset($_SESSION['usuario'])) {
    header('Location: telaInicial.php');
    exit();
}

?>
<script src="../../Public/js/enquetes.js" defer></script>
<title>Enquetes</title>

<body class="enquetes-body">
	<div class="votarProduto-Sidebar">

		<div class="votarProduto-logo">
			<img src="../../Public/img/logo.avif" alt="">
			<h1>Buy <span>At</span> Home</h1>
		</div>

		<div class="votarProduto-burguer">
            <i class="fa-solid fa-bars"></i>
		</div>

	</div>

    <div class="menu-dropdown" id="menuDropdown">
      <p class="menu-username">Olá, <span id="nomeUsuario"><?php echo $_SESSION['usuario']['username']; ?></span></p>
      <button onclick="window.location.href='../Controller/logout.php'">Sair</button>
    </div>


    <section class="enquetes-section" >

        <div class="enquetes-sectionText">
            <h1>Enquetes</h1>
            <p>Vote e faça a diferença!</p>
        </div>

        <div class="enquetes-container" id="carregarEnquetes">
        </div>
        <h1 style="text-align: center;" id="erroRequisicao">Não há enquetes no momento</h1>

    </section>


</body>