<?php

require "conexaoMysql.php";
$pdo = mysqlConnect();

$nome = $_POST["nome"] ?? "";
$cpf  = $_POST["cpf"] ?? "";
$email = $_POST["email"] ?? "";
$premio = $_POST["premio"] ?? "";


$dependente = $_POST["dependente"] ?? "";
$relacao = $_POST["relacao"] ?? "";
$nascimento = $_POST["nascimento"] ?? "";


$sql1 = <<<SQL
  INSERT INTO segurado (nome_seg, cpf, email, premio)
  VALUES (?, ?, ?, ?)
  SQL;

$sql2 = <<<SQL
  INSERT INTO dependente
    (nome_dep, relacao, data_nascimento,id_segurado)
  VALUES (?, ?, ?, ?, ?)
  SQL;

try {
  $pdo->beginTransaction();

  
  $stmt1 = $pdo->prepare($sql1);
  if (!$stmt1->execute([
    $nome, $cpf, $email, $premio,
    $dependente, $relacao, $nascimento
  ])) throw new Exception('Falha na primeira inserção');


  $idSegurado = $pdo->lastInsertId();
  $stmt2 = $pdo->prepare($sql2);
  if (!$stmt2->execute([
    $dependente, $relacao, $nascimento, $idSegurado
  ])) throw new Exception('Falha na segunda inserção');

 
  $pdo->commit();

  header("location: questao1.html");
  exit();
} 
catch (Exception $e) {
  $pdo->rollBack();
  if ($e->errorInfo[1] === 1062)
    exit('Dados duplicados: ' . $e->getMessage());
  else
    exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}