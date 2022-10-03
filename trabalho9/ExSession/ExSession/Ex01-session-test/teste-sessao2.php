<?php

// inicializa a sessão
session_start();

?>
<!DOCTYPE html>
<html>
<body>

<?php

// acessa as variáveis de sessão definidas anteriormente
// no script session1.php
$nome  = $_SESSION["nome"];
$email = $_SESSION["email"];

echo "Bem vindo, $nome <br>";
echo "Seu e-mail é $email <br>";
echo "Seus dados foram guardados em variáveis de sessao pela pagina anterior!";

?>

</body>
</html>