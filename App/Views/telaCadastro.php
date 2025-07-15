<?php
include __DIR__.'/../../Public/includes/header.php';
?>

<body class="task001-body">
  <div class="task001-container">
    <img class="task001-logo" src="../../Public/img/Logo.png" alt="Logo">
    <h1 class="task001-title">Cadastrar</h1>
    <h2 class="task001-subtitle">Crie uma conta para ter tudo que
    você precisa, na hora que você quer</h2>
    <form class="task001-container-inputs">
        <div class="task001-input-box">
            <i class="fa-solid fa-user task001-input-icon"></i>
            <input type="text" name="task001-input-1" class="task001-inputs" placeholder="Usuario">
        </div>
        <div class="task001-input-box">
            <i class="fa-solid fa-at task001-input-icon"></i>
            <input type="text" name="task001-input-2" class="task001-inputs" placeholder="email">
        </div>
        <div class="task001-input-box">
            <i class="fa-solid fa-lock task001-input-icon"></i>
            <input type="password" name="task001-input-3" class="task001-inputs" placeholder="Senha">
        </div>
        <div class="task001-input-box">
            <i class="fa-solid fa-lock task001-input-icon"></i>
            <input type="password" name="task001-input-3" class="task001-inputs" placeholder="ConfSenha">
        </div>
        <button class="task001-button-cadastrar">Cadastrar</button>
    </form>
    <h2 class="task001-ja-possui-conta">Já tem uma conta?<a href="#" class="task001-ir-para-login">Fazer login.</a></h2>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous" class="task001-script"></script>
</body>