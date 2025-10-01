<?php
// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Coleta e limpa os dados do formulário
    $nome = strip_tags(trim($_POST["nome"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mensagem = strip_tags(trim($_POST["mensagem"]));

    // 2. Validação simples no servidor
    if (empty($nome) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($mensagem)) {
        // Se algum campo estiver inválido, redireciona com erro
        header("Location: index.php?status=erro");
        exit;
    }

    // 3. Monta o corpo do e-mail
    $destinatario = "seu-email@exemplo.com"; // <-- SUBSTITUA PELO SEU E-MAIL
    $assunto = "Nova mensagem do site de $nome";

    $corpo_email = "Nome: $nome\n";
    $corpo_email .= "Email: $email\n\n";
    $corpo_email .= "Mensagem:\n$mensagem\n";

    $headers = "From: $nome <$email>";

    // 4. Envia o e-mail
    // A função mail() depende da configuração do servidor. Em um servidor local (XAMPP),
    // pode não funcionar sem configuração adicional. Em um host web, geralmente funciona.
    if (mail($destinatario, $assunto, $corpo_email, $headers)) {
        // Se o e-mail foi enviado, redireciona com sucesso
        header("Location: index.php?status=sucesso");
    } else {
        // Se houve uma falha no envio, redireciona com erro
        header("Location: index.php?status=erro");
    }

} else {
    // Se alguém tentar acessar o arquivo diretamente, redireciona
    header("Location: index.php");
}
?>