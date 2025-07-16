// Public/js/login.js
document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.querySelector('.formLogin');
    const loginButton = document.querySelector('.botao-lg');
    const messageBox = document.getElementById('messageBox');
    const messageText = document.getElementById('messageText');
    const closeMessageBox = document.getElementById('closeMessageBox');

    // Function to display messages in a custom modal
    function showMessage(message, isSuccess = false) {
        messageText.textContent = message;
        messageBox.style.backgroundColor = isSuccess ? '#4CAF50' : '#f44336'; // Green for success, Red for error
        messageBox.classList.add('show'); // Add class to trigger opacity transition
        messageBox.style.display = 'block';
        
        // Hide after 5 seconds
        setTimeout(() => {
            messageBox.classList.remove('show');
            setTimeout(() => {
                messageBox.style.display = 'none';
            }, 300); // Allow transition to finish before hiding display
        }, 5000);
    }

    if (closeMessageBox) {
        closeMessageBox.addEventListener('click', () => {
            messageBox.classList.remove('show');
            setTimeout(() => {
                messageBox.style.display = 'none';
            }, 300); // Allow transition to finish before hiding display
        });
    }

    // Verifica se os elementos existem antes de adicionar o event listener
    if (loginForm && loginButton) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault(); // Impede o envio padrão do formulário

            // Coleta os valores dos campos do formulário
            const email = document.querySelector('.formLogin input[name="email"]').value;
            const password = document.querySelector('.formLogin input[name="password"]').value;

            // Validações básicas no frontend
            if (!email || !password) {
                showMessage('Por favor, preencha o e-mail e a senha.');
                return;
            }

            try {
                // CORREÇÃO CRÍTICA: Use o caminho ABSOLUTO para o controlador PHP
                // Assumindo que 'PsyCoders' é a pasta raiz do seu projeto no localhost
                const response = await fetch('/PsyCoders/App/Controllers/AuthController.php?action=login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password
                    })
                });

                // Verifica se a resposta HTTP foi bem-sucedida (status 2xx)
                if (!response.ok) {
                    let errorData;
                    try {
                        errorData = await response.json();
                    } catch (jsonError) {
                        const errorText = await response.text();
                        console.error('HTTP Error (Non-JSON Response):', response.status, response.statusText, errorText);
                        showMessage(`Erro do servidor: ${response.status} ${response.statusText}. Verifique o console para mais detalhes.`);
                        return;
                    }
                    console.error('HTTP Error (JSON Response):', response.status, response.statusText, errorData);
                    showMessage(errorData.message || `Erro do servidor: ${response.status} ${response.statusText}.`);
                    return;
                }

                // Converte a resposta do servidor para JSON
                const data = await response.json();

                // Manipula a resposta do servidor
                if (data.success) {
                    showMessage(data.message, true); // Pass true for success message
                    if (data.redirect) {
                        // Adicionar um pequeno atraso antes do redirecionamento
                        setTimeout(() => {
                            window.location.href = data.redirect; // Redireciona para a página de sucesso (telaInicial.php)
                        }, 1500); // 1.5 seconds delay
                    }
                } else {
                    showMessage(data.message); // Exibe a mensagem de erro do servidor
                }
            } catch (error) {
                console.error('Erro na requisição de login:', error);
                showMessage('Ocorreu um erro ao tentar fazer login. Por favor, tente novamente.');
            }
        });
    } else {
        console.warn('Formulário de login ou botão não encontrados. Verifique os seletores CSS.');
    }
});
