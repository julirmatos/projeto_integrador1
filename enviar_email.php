<?php
header('Content-Type: application/json');

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- INFORMAÇÕES IMPORTANTES ---
    // Substitua este e-mail pelo e-mail que receberá as mensagens do formulário
    $destinatario = "diefurlann@hotmail.com"; 

    // --- COLETA E LIMPEZA DOS DADOS ---
    // Usamos filter_input para mais segurança contra ataques como XSS
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_SPECIAL_CHARS);

    // --- VALIDAÇÃO DOS DADOS ---
    if (!$nome || !$email || !$telefone || !$mensagem) {
        $response['status'] = 'error';
        $response['message'] = 'Dados inválidos ou faltando. Por favor, preencha o formulário corretamente.';
        echo json_encode($response);
        exit;
    }

    // --- MONTAGEM DO E-MAIL ---
    $assunto = "Nova mensagem do site É de Casa' de: $nome";
    
    $corpo_email = "Você recebeu uma nova mensagem do seu site.\n\n";
    $corpo_email .= "Nome: $nome\n";
    $corpo_email .= "Email: $email\n";
    $corpo_email .= "Telefone: $telefone\n";
    $corpo_email .= "Mensagem:\n$mensagem\n";

    // Cabeçalhos do e-mail
    $headers = "From: nao-responda@seudominio.com\r\n"; // Use um e-mail do seu domínio de hospedagem
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

    // --- ENVIO DO E-MAIL ---
    if (mail($destinatario, $assunto, $corpo_email, $headers)) {
        $response['status'] = 'success';
        $response['message'] = 'Mensagem enviada com sucesso! Entraremos em contato em breve.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Desculpe, ocorreu um erro ao tentar enviar sua mensagem. Tente novamente mais tarde.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Método de requisição inválido.';
}

echo json_encode($response);
?>