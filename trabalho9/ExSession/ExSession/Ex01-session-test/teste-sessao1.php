<?php

// inicializa a sessão
session_start();

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';

// define as variáveis de sessão
$_SESSION["nome"]  = $nome;
$_SESSION["email"] = $email;

?>

<!DOCTYPE html>
<html>

<body>
  <h2>Variáveis de sessão definidas!</h2>
  <h3><a href="teste-sessao2.php">Acessar outro script PHP</a></h3>
</body>

</html>