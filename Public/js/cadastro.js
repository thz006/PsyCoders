// Public/js/cadastro.js

document.addEventListener('DOMContentLoaded', () => {
    const cadastroForm = document.querySelector('.task001-container-inputs');
    const messageBox = document.getElementById('messageBox');
    const messageText = document.getElementById('messageText');
    const closeMessageBox = document.getElementById('closeMessageBox');

    function showMessage(message, isSuccess = false) {
        if (messageText && messageBox) {
            messageText.textContent = message;
            messageBox.style.backgroundColor = isSuccess ? '#4CAF50' : '#f44336';
            messageBox.classList.add('show');
            messageBox.style.display = 'block';
            setTimeout(() => {
                messageBox.classList.remove('show');
                setTimeout(() => {
                    messageBox.style.display = 'none';
                }, 300);
            }, 5000);
        } else {
            alert(message);
        }
    }

    if (closeMessageBox) {
        closeMessageBox.addEventListener('click', () => {
            messageBox.classList.remove('show');
            setTimeout(() => {
                messageBox.style.display = 'none';
            }, 300);
        });
    }

    if (cadastroForm) {
        cadastroForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const username = document.querySelector('input[name="username"]').value.trim();
            const email = document.querySelector('input[name="email"]').value.trim();
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;

            if (!username || !email || !password || !confirmPassword) {
                showMessage('Por favor, preencha todos os campos.');
                return;
            }
            if (password !== confirmPassword) {
                showMessage('As senhas não coincidem!');
                return;
            }

            try {
                const response = await fetch('/PsyCoders/App/Controller/AuthController.php?action=register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ username, email, password, confirm_password: confirmPassword })
                });
                const data = await response.json();
                if (response.ok && data.success) {
                    showMessage(data.message, true);
                    setTimeout(() => {
                        window.location.href = 'telaLogin.php';
                    }, 1500);
                } else {
                    showMessage(data.message || 'Erro ao cadastrar.');
                }
            } catch (error) {
                showMessage('Erro de conexão com o servidor.');
            }
        });
    } else {
        console.warn('Formulário de cadastro não encontrado.');
    }
}); 