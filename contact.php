<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = strip_tags(trim($_POST["nome"]));
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $telefone = strip_tags(trim($_POST["telefone"]));
  $mensagem = trim($_POST["mensagem"]);

  if (empty($nome) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($mensagem)) {
    echo "Erro: Preencha todos os campos corretamente.";
    exit;
  }

  $to = "restauranteedecasa@gmail.com"; // e-mail real do restaurante
  $subject = "Nova mensagem do site É de Casa";

  $content = "Nome: $nome\n";
  $content .= "Email: $email\n";
  $content .= "Telefone: $telefone\n\n";
  $content .= "Mensagem:\n$mensagem\n";

  $headers = "From: $nome <$email>";

  if (mail($to, $subject, $content, $headers)) {
    echo "Mensagem enviada com sucesso!";
  } else {
    echo "Erro ao enviar a mensagem. Tente novamente mais tarde.";
  }
} else {
  echo "Erro: Método inválido.";
}
?>
