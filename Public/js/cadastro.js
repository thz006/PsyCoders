document.addEventListener('DOMContentLoaded', () => {
    
    const form = document.querySelector('.task001-container-inputs');
    const messageBox = document.getElementById('messageBox');
    const messageText = document.getElementById('messageText');
    const closeButton = document.getElementById('closeMessageBox');

    // Função para mostrar mensagens
    function showMessage(message, isSuccess = false) {
        if (!messageBox || !messageText) {
            alert(message);
            return;
        }

        messageText.textContent = message;
        messageBox.style.backgroundColor = isSuccess ? '#4CAF50' : '#f44336';
        messageBox.style.display = 'block';

        setTimeout(() => {
            messageBox.style.display = 'none';
        }, 5000);
    }

    // Fecha manualmente a caixa de mensagem
    if (closeButton) {
        closeButton.addEventListener('click', () => {
            messageBox.style.display = 'none';
        });
    }

    // Lógica principal do formulário
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const username = form.querySelector('input[name="username"]').value.trim();
            const email = form.querySelector('input[name="email"]').value.trim();
            const password = form.querySelector('input[name="password"]').value;
            const confirmPassword = form.querySelector('input[name="confirm_password"]').value;

            // Validações
            if (!username || !email || !password || !confirmPassword) {
                showMessage('Preencha todos os campos.');
                return;
            }

            const senhaForte = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            if (!senhaForte.test(password)) {
                showMessage('A senha deve ter no mínimo 8 caracteres, incluindo: letra maiúscula, minúscula, número e caractere especial.');
                return;
            }

            if (password !== confirmPassword) {
                showMessage('As senhas não coincidem.');
                return;
            }

            // Envia os dados
            try {
                const response = await fetch('../../App/Controller/CadastroController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        username,
                        email,
                        password,
                        confirm_password: confirmPassword
                    })
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    showMessage(result.message, true);
                    setTimeout(() => {
                        window.location.href = 'telaLogin.php';
                    }, 1500);
                } else {
                    showMessage(result.message || 'Erro ao cadastrar.');
                }
            } catch (error) {
                console.error(error);
                showMessage('Erro ao conectar com o servidor.');
            }
        });
    } else {
        console.warn('Formulário de cadastro não encontrado.');
    }
});
