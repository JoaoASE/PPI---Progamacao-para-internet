<?php

require "conexaoMysql.php";
$pdo = mysqlConnect();



$cep = $_GET['cep'] ?? '';

$sql = <<<SQL
    SELECT rua, bairro, cidade
    FROM tab7_endereco
    WHERE cep = ?
    SQL;

try{
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$cep]);
  $row = $stmt->fetch();
} catch (Exception $e) {
  exit('Ocorreu uma falha: ' . $e->getMessage());
}


class Endereco
{
  public $rua;
  public $bairro;
  public $cidade;

  function __construct($rua, $bairro, $cidade)
  {
    $this->rua = $rua;
    $this->bairro = $bairro; 
    $this->cidade = $cidade;
  }
}

if($row){
  $rua = htmlspecialchars($row['rua']);
  
  $bairro = htmlspecialchars($row['bairro']);
  
  $cidade = htmlspecialchars($row['cidade']);

  $endereco = new Endereco($rua, $bairro, $cidade);
} else {
  $endereco = new Endereco('', '', '');
}

echo json_encode($endereco);