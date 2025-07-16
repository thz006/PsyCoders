// Public/js/cadastro.js
document.addEventListener('DOMContentLoaded', () => {
    const cadastroForm = document.querySelector('.task001-container-inputs');
    const cadastroButton = document.querySelector('.task001-button-cadastrar');
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
    if (cadastroForm && cadastroButton) {
        cadastroForm.addEventListener('submit', async (e) => {
            e.preventDefault(); // Impede o envio padrão do formulário

            // Coleta os valores dos campos do formulário
            const username = document.querySelector('input[name="username"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;

            // Validações básicas no frontend
            if (!username || !email || !password || !confirmPassword) {
                showMessage('Por favor, preencha todos os campos.');
                return;
            }

            if (password !== confirmPassword) {
                showMessage('As senhas não coincidem!');
                return;
            }

            try {
                // CORREÇÃO CRÍTICA: Use o caminho ABSOLUTO para o controlador PHP
                // Assumindo que 'PsyCoders' é a pasta raiz do seu projeto no localhost
                const response = await fetch('/PsyCoders/App/Controllers/AuthController.php?action=register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json' // Informa ao servidor que estamos enviando JSON
                    },
                    body: JSON.stringify({ // Converte os dados para JSON
                        username: username,
                        email: email,
                        password: password,
                        confirm_password: confirmPassword
                    })
                });

                // Verifica se a resposta HTTP foi bem-sucedida (status 2xx)
                if (!response.ok) {
                    // Tenta ler a resposta como JSON para ver se há uma mensagem de erro do PHP
                    let errorData;
                    try {
                        errorData = await response.json();
                    } catch (jsonError) {
                        // Se não for JSON, pega o texto bruto para depuração
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
                    // Adicionar um pequeno atraso antes do redirecionamento
                    setTimeout(() => {
                        window.location.href = 'telaLogin.php'; // Redireciona para a tela de login
                    }, 1500); // 1.5 seconds delay
                } else {
                    showMessage(data.message); // Exibe a mensagem de erro do servidor
                }
            } catch (error) {
                console.error('Erro na requisição de cadastro:', error);
                showMessage('Ocorreu um erro ao tentar cadastrar. Por favor, tente novamente.');
            }
        });
    } else {
        console.warn('Formulário de cadastro ou botão não encontrados. Verifique os seletores CSS.');
    }
});
