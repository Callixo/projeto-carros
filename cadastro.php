<?php $pagina_publica = true; ?>
<?php $titulo_pagina = 'Cadastro de Usuário'; ?>
<?php require 'includes/header.php'; ?>

<div class="form-container" style="max-width: 700px;"> <h2>Crie sua Conta</h2>
    <p>Preencha os campos para se cadastrar.</p>

    <?php
    if (isset($_GET['error'])) {
        echo '<p class="mensagem-erro">' . htmlspecialchars($_GET['error']) . '</p>';
    }
    ?>

    <form action="auth/processa_cadastro.php" method="POST" id="form-cadastro">
        <fieldset>
            <legend>Dados Pessoais</legend>
            <div class="form-group">
                <label for="nome_completo">Nome Completo</label>
                <input type="text" id="nome_completo" name="nome_completo" required minlength="15" maxlength="80">
            </div>
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento</label>
                <input type="date" id="data_nascimento" name="data_nascimento" required>
            </div>
            <div class="form-group">
                <label for="sexo">Sexo</label>
                <select id="sexo" name="sexo" required>
                    <option value="">Selecione...</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nome_materno">Nome Materno</label>
                <input type="text" id="nome_materno" name="nome_materno" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" required placeholder="000.000.000-00">
            </div>
        </fieldset>

        <fieldset>
            <legend>Contato e Endereço</legend>
            <div class="form-group">
                <label for="telefone_celular">Telefone Celular</label>
                <input type="text" id="telefone_celular" name="telefone_celular" required placeholder="(+55)XX-XXXXXXXXX">
            </div>
            <div class="form-group">
                <label for="telefone_fixo">Telefone Fixo</label>
                <input type="text" id="telefone_fixo" name="telefone_fixo" required placeholder="(+55)XX-XXXXXXXX">
            </div>
            <div class="form-group">
                <label for="endereco_completo">Endereço Completo</label>
                <input type="text" id="endereco_completo" name="endereco_completo" required>
            </div>
        </fieldset>

        <fieldset>
            <legend>Credenciais de Acesso</legend>
            <div class="form-group">
                <label for="login">Login (mínimo 6 caracteres)</label>
                <input type="text" id="login" name="login" required minlength="6">
            </div>
            <div class="form-group">
                <label for="senha">Senha (mínimo 8 caracteres, com letras, números e símbolos)</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="confirmar_senha">Confirmação da Senha</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" required>
            </div>
        </fieldset>
        
        <fieldset>
            <legend>Perguntas de Segurança (para recuperação)</legend>
            <div class="form-group">
                <label for="resposta_pet">Qual o nome do seu pet?</label>
                <input type="text" id="resposta_pet" name="respostas[pet]" required>
            </div>
            <div class="form-group">
                <label for="resposta_nascimento">Qual a data do seu nascimento?</label>
                <input type="date" id="resposta_nascimento" name="respostas[nascimento]" required>
            </div>
             <div class="form-group">
                <label for="resposta_cep">Qual o CEP do seu endereço?</label>
                <input type="text" id="resposta_cep" name="respostas[cep]" required>
            </div>
        </fieldset>

        <div class="form-buttons">
            <button type="submit" class="btn">Enviar</button>
            <button type="reset" class="btn btn-secondary">Limpar</button>
        </div>
    </form>
    <p class="text-center">Já tem uma conta? <a href="login.php">Faça o login</a></p>
</div>
<script src="https://unpkg.com/imask"></script>
<script>
    // Aplica máscaras aos campos
    IMask(document.getElementById('cpf'), { mask: '000.000.000-00' });
    IMask(document.getElementById('telefone_celular'), { mask: '(+55)00-000000000' });
    IMask(document.getElementById('telefone_fixo'), { mask: '(+55)00-00000000' });
    IMask(document.getElementById('resposta_cep'), { mask: '00000-000' });

    // Validação de confirmação de senha
    const form = document.getElementById('form-cadastro');
    const senha = document.getElementById('senha');
    const confirmarSenha = document.getElementById('confirmar_senha');
    form.addEventListener('submit', function(e) {
        if (senha.value !== confirmarSenha.value) {
            e.preventDefault(); // Impede o envio do formulário
            alert('A confirmação da senha não corresponde à senha digitada.');
        }
    });
</script>

<?php require 'includes/footer.php'; ?>