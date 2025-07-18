document.addEventListener('DOMContentLoaded', () => {
    const btnFuncionario = document.getElementById('btnFuncionario');
    const form = document.querySelector('.formLogin');
    const messageBox = document.getElementById('messageBox');
    const messageText = document.getElementById('messageText');
    const closeButton = document.getElementById('closeMessageBox');

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

    if (closeButton) {
        closeButton.addEventListener('click', () => {
            messageBox.style.display = 'none';
        });
    }

    if (btnFuncionario && form) {
        btnFuncionario.addEventListener('click', async () => {
            const email = form.querySelector('input[name="email"]').value.trim();
            const password = form.querySelector('input[name="password"]').value;

            if (!email || !password) {
                showMessage('Preencha email e senha.');
                return;
            }

            try {
                const response = await fetch('../../App/Controller/LoginAdmController.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showMessage(data.message, true);
                    setTimeout(() => {
                        window.location.href = 'telaAdm.php';
                    }, 1500);
                } else {
                    showMessage(data.message || 'Erro ao fazer login como funcionário.');
                }
            } catch (error) {
                showMessage('Erro ao conectar com o servidor.');
            }
        });
    }
});
