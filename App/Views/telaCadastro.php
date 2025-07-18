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
        <h1 class="task001-title">Cadastrar</h1>
        <h2 class="task001-subtitle">Crie uma conta para ter tudo que
        você precisa, na hora que você quer</h2>
        <form class="task001-container-inputs" method="post">
            <div class="task001-input-box">
                <i class="fa-solid fa-user task001-input-icon"></i>
                <input type="text" name="username" class="task001-inputs" placeholder="Usuário" required>
            </div>
            <div class="task001-input-box">
                <i class="fa-solid fa-at task001-input-icon"></i>
                <input type="email" name="email" class="task001-inputs" placeholder="Email" required>
            </div>
            <div class="task001-input-box">
                <i class="fa-solid fa-lock task001-input-icon"></i>
                <input type="password" name="password" class="task001-inputs" placeholder="Senha" required>
            </div>
            <div class="task001-input-box">
                <i class="fa-solid fa-lock task001-input-icon"></i>
                <input type="password" name="confirm_password" class="task001-inputs" placeholder="Confirmar Senha" required>
            </div>

            <button type="submit" class="task001-button-cadastrar">Cadastrar</button>
        </form>
        <h2 class="task001-ja-possui-conta">Já tem uma conta?<a href="telaLogin.php" class="task001-ir-para-login">Fazer login.</a></h2>
    </div>
    <script src="../../Public/js/cadastro.js"></script>
</body>
</html>
