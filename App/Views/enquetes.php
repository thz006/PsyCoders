<?php include '../../Public/includes/header.php'; 
include '../../App/Model/User.php'; 
session_start();


if (!isset($_SESSION['username']['user_id'])) {
header('Location: telaInicial.php');
exit();
}

$id_user =  $_SESSION['user_id'];
$user = new User();

$result = $user->getUser($id_user);
print_r($result);
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
			
		</div>

	</div>

    <section class="enquetes-section" >

        <div class="enquetes-sectionText">
            <h1>Enquetes</h1>
            <p>Vote e faça a diferença!</p>
        </div>

        <div class="enquetes-container" id="carregarEnquetes">

            <!-- <div class="enquete-card">
                <h1>Top da Semana</h1>
                <div class="enquete-info">
                    <p>Até 18 de julho</p>
                    <p>3 opções</p>
                </div>
            </div>


            <div class="enquete-card">
                <h1>Qual sua bebida favorita?</h1>
                <div class="enquete-info">
                    <p>Até 31 de julho</p>
                    <p>8 opções</p>
                </div>
            </div>

            <div class="enquete-card">
                <h1>Melhores unidades</h1>
                <div class="enquete-info">
                    <p>Até 31 de agosto</p>
                    <p>5 opções</p>
                </div>
            </div>

            <div class="enquete-card">
                <h1>Top da Semana</h1>
                <div class="enquete-info">
                    <p>Até 18 de julho</p>
                    <p>3 opções</p>
                </div>
            </div>
            
            <div class="enquete-card">
                <h1>Promoções Especiais</h1>
                <div class="enquete-info">
                    <p>Até 31 de julho</p>
                    <p>4 opções</p>
                </div>
            </div>

            <div class="enquete-card">
                <h1>Como você conheceu nosso site?</h1>
                <div class="enquete-info">
                    <p></p>
                    <p>6 opções</p>
                </div>
            </div> -->
          
            <!-- <div class="enquete-pagination">
                <button>1</button>
                <button>2</button>
                <button>3</button>
            </div> -->

        </div>
        <h1 style="text-align: center;" id="erroRequisicao">Não há enquetes no momento</h1>

    </section>


</body>