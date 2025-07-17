
document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.querySelector('.formLogin');
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

    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.querySelector('input[name="email"]').value.trim();
            const password = document.querySelector('input[name="password"]').value;

            if (!email || !password) {
                showMessage('Por favor, preencha todos os campos.');
                return;
            }

            try {
                const response = await fetch('/PsyCoders/App/Controller/AuthController.php?action=login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                const data = await response.json();
                if (response.ok && data.success) {
                    showMessage(data.message, true);
                    setTimeout(() => {
                        window.location.href = data.redirect || 'enquetes.php';
                    }, 1200);
                } else {
                    showMessage(data.message || 'Erro ao fazer login.');
                }
            } catch (error) {
                showMessage('Erro de conexão com o servidor.');
            }
        });
    } else {
        console.warn('Formulário de login não encontrado.');
    }
}); 