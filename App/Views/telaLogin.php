<?php

include __DIR__.'/../../Public/includes/header.php';
?>

<body class="task001-body">
    <div id="messageBox">
        <span id="messageText"></span>
        <button id="closeMessageBox">&times;</button>
    </div>

    <a href="telaInicial.php" class="botao-voltar"><i class="fa-solid fa-angle-left"></i>Voltar</a>
    <div class="task001-container">
        <h1 class="task001-logo-text"><img src="../../Public/img/logo_mg.png" alt="">Buy<span>At</span>Home</h1>
        <h1 class="task001-title">Login</h1>
        <h2 class="task001-subtitle">Acesse sua conta para continuar</h2>
        <form class="formLogin">
            <div class="task001-input-box">
                <i class="fa-solid fa-at task001-input-icon"></i>
                <input type="email" name="email" class="task001-inputs" placeholder="Email" required>
            </div>
            <div class="task001-input-box">
                <i class="fa-solid fa-lock task001-input-icon"></i>
                <input type="password" name="password" class="task001-inputs" placeholder="Senha" required>
            </div>

            <button type="button" id="btnUsuario" class="botao-lg">Entrar Como Usuário</button>
            <button type="button" class="botao-lg botao-funcionario" id="btnFuncionario">Entrar Como Funcionário</button>
        </form>
        <h2 class="task001-ja-possui-conta">Não tem uma conta?<a href="telaCadastro.php" class="task001-ir-para-login">Cadastre-se.</a></h2>
    </div>
    <script src="../../Public/js/loginUsuario.js"></script>
    <script src="../../Public/js/loginFuncionario.js"></script>
</body>
</html>
