<?php
include '../../Public/includes/header.php';
?>
<title>Tela Login</title>
<body class="bodyLogin">
    <a href="telaInicial.php" class="botao-voltar"><i class="fa-solid fa-angle-left"></i>Voltar</a>
    <section class="areaLogin">
        <h1><img src="../../Public/img/logo_mg.png" alt="">Buy<span>At</span>Home</h1>
        <h2>Login</h2>
        <p class="loginWelcome">Entre em sua conta para ter
        acesso a conteudos incríveis!</p>

        <form action="" class="formLogin">
            <div class="areaInput">
                <i class="fa-solid fa-at"></i><input type="email" name="" placeholder="email">
            </div>
            <div class="areaInput">
                <i class="fa-solid fa-lock"></i><input type="password" name="" placeholder="senha">
            </div>
           
           
            <input class="botao-lg" type="submit" value="Fazer Login">
            <p class="loginInfo">Não tem uma conta? <a href="">Cadastrar</a></p>
        </form>
    </section>
</body>
</html>