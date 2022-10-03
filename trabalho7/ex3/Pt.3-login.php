<?php

class RequestResponse {
  public $success;
  public $destination;

  function __construct($success, $destination) {
    $this->success = $success;
    $this->destination = $destination;
  }
}

function checkLogin($pdo, $email, $senha)
{
  $sql = <<<SQL
    SELECT hash_senha
    FROM cad_exe_3
    WHERE email = ?
    SQL;

  try {
    // Neste caso utilize prepared statements para prevenir
    // ataques do tipo SQL Injection, pois precisamos
    // inserir dados fornecidos pelo usuário na 
    // consulta SQL (email)
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    if (!$row)
      return false; // nenhum resultado (email não encontrado)
    else
      return password_verify($senha, $row['hash_senha']);
  } 
  catch (Exception $e) {
    //error_log($e->getMessage(), 3, 'log.php');
    exit('Falha inesperada: ' . $e->getMessage());
  }
}

$errorMsg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require "conexaoMysql.php";
  $pdo = mysqlConnect();

  $email = $senha = "";

  if (isset($_POST["email"]))
    $email = htmlspecialchars($_POST["email"]);
  if (isset($_POST["senha"]))
    $senha = htmlspecialchars($_POST["senha"]);

  if (checkLogin($pdo, $email, $senha)) {
    $requestResponse = new RequestResponse(true, "novapagina.html");
  } else {
    $errorMsg = "Dados incorretos";
    $requestResponse = new RequestResponse(false, "");
  }

  echo json_encode($requestResponse);
}

?>