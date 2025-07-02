document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    const formMessage = document.getElementById('form-message');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Previne o envio padrão do formulário

        // Validação simples no front-end
        const nome = document.getElementById('nome').value.trim();
        const email = document.getElementById('email').value.trim();
        const telefone = document.getElementById('telefone').value.trim();
        const mensagem = document.getElementById('mensagem').value.trim();

        if (nome === '' || email === '' || telefone === '' || mensagem === '') {
            showMessage('Por favor, preencha todos os campos.', 'error');
            return;
        }

        // Envia os dados usando Fetch API
        const formData = new FormData(form);
        
        fetch('enviar_email.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showMessage(data.message, 'success');
                form.reset(); // Limpa o formulário
            } else {
                showMessage(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showMessage('Ocorreu um erro ao enviar a mensagem. Tente novamente mais tarde.', 'error');
        });
    });

    function showMessage(message, type) {
        formMessage.textContent = message;
        formMessage.style.padding = '10px';
        formMessage.style.marginBottom = '15px';
        formMessage.style.borderRadius = '5px';
        formMessage.style.color = '#fff';

        if (type === 'success') {
            formMessage.style.backgroundColor = '#28a745'; // Verde
        } else {
            formMessage.style.backgroundColor = '#dc3545'; // Vermelho
        }
    }
});