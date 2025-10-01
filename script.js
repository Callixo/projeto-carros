document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formContato');

    form.addEventListener('submit', function(event) {
        const nome = document.getElementById('nome').value.trim();
        const email = document.getElementById('email').value.trim();
        const mensagem = document.getElementById('mensagem').value.trim();

        if (nome === '' || email === '' || mensagem === '') {
            // Impede o envio do formulário
            event.preventDefault();
            alert('Por favor, preencha todos os campos.');
        }
    });
});