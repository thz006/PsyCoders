<?php
// Arquivo: gerar_senha.php

// 1. Coloque aqui a senha que você quer usar para o admin
$senha_do_admin = 'admin123'; 

// 2. Este código vai gerar o hash seguro
$hash_da_senha = password_hash($senha_do_admin, PASSWORD_DEFAULT);

// 3. Isso vai exibir o hash na tela para você copiar
echo '<h3>Hash da Senha Gerado!</h3>';
echo 'Copie o código abaixo e cole na coluna "Senha" do seu administrador no banco de dados:';
echo '<br><br>';
echo '<p style="font-family: monospace; background-color: #f0f0f0; padding: 10px; border: 1px solid #ccc;">' . $hash_da_senha . '</p>';

?>