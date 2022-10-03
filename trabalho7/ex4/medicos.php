<?php

require "conexaoMysql.php";
$pdo = mysqlConnect();





try{
  $sql = <<<SQL
    SELECT nome_medico, telefone_medico
    FROM cad_med
    WHERE especialidade_medico = ?
    SQL;

  $stmt = $pdo->prepare($sql);
} catch (Exception $e) {
  exit('Ocorreu uma falha: ' . $e->getMessage());
}

$especialidade = $_GET['especialidade'] ?? '';


class Medico
{
  public $nome;
  public $telefone;
  public $especialidade;

  function __construct($nome, $telefone, $especialidade)
  {
    $this->nome = $nome;
    $this->telefone = $telefone; 
    $this->especialidade = $especialidade;
  }
}

$stmt->execute([$especialidade]);


$medicos = array();
while ($row = $stmt->fetch()) {
  array_push($medicos, new Medico($row['nome_medico'], $row['telefone_medico'], $row['especialidade_medico']));
}
echo json_encode($medicos);