<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = strip_tags(trim($_POST["nome"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $assunto = strip_tags(trim($_POST["assunto"]));
    $mensagem = strip_tags(trim($_POST["mensagem"]));

    if (empty($nome) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($assunto) || empty($mensagem)) {
        http_response_code(400);
        echo "Por favor, preencha todos os campos do formulário.";
        exit;
    }

    $destinatario = "seu-email@seudominio.com"; // <-- MUDE PARA O SEU E-MAIL
    $cabecalhos = "From: $nome <$email>";

    $conteudo_email = "Nome: $nome\n";
    $conteudo_email .= "Email: $email\n\n";
    $conteudo_email .= "Assunto: $assunto\n\n";
    $conteudo_email .= "Mensagem:\n$mensagem\n";

    if (mail($destinatario, $assunto, $conteudo_email, $cabecalhos)) {
        http_response_code(200);
        echo "Obrigado! Sua mensagem foi enviada com sucesso.";
        // Você pode redirecionar para uma página de "obrigado" aqui.
        // header("Location: obrigado.html");
    } else {
        http_response_code(500);
        echo "Oops! Algo deu errado e não conseguimos enviar sua mensagem.";
    }

} else {
    http_response_code(403);
    echo "Houve um problema com seu envio, por favor, tente novamente.";
}
?>