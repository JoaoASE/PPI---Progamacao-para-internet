<?php

require "conexaoMysql.php";
$pdo = mysqlConnect();

try {

  $sql = <<<SQL
  SELECT nome_dep, relacao, data_nascimento, nome_seg, cpf, email, premio
  FROM dependente, segurado
  WHERE segurado.id = dependente.id_segurado
  SQL;


  $stmt = $pdo->query($sql);
} 
catch (Exception $e) {
  
  exit('Ocorreu uma falha: ' . $e->getMessage());
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Segurado e dependentes</title>

  
  <style>
    body {
      padding-top: 2rem;
    }
  </style>
</head>

<body>

  <div class="container">
    <h3>Segurado e Dependentes</h3>
    <table class="table table-striped table-hover">
      <tr>
        <th>Dependente</th>
        <th>Relacao</th>
        <th>Data Nascimento</th>
        <th>Nome Segurado</th>
        <th>CPF</th>
        <th>Email</th>
        <th>Premio</th>
        <th>Id</th>
      </tr>

      <?php
      while ($row = $stmt->fetch()) {


        $dependente = htmlspecialchars($row['dependente']);
        $relacao = htmlspecialchars($row['relacao']);
        $data_nascimento = htmlspecialchars($row['data_nascimento']);
        $nome = htmlspecialchars($row['nome']);
        $cpf = htmlspecialchars($row['cpf']);
        $email = htmlspecialchars($row['email']);
        $premio = htmlspecialchars($row['premio']);
        $id = htmlspecialchars($row['id']);

        echo <<<HTML
          <tr>
            <td>$dependente</td>
            <td>$relacao</td>
            <td>$data_nascimento</td>
            <td>$nome</td> 
            <td>$email</td>
            <td>$premio</td>
            <td>$id</td>
          </tr>      
        HTML;
      }
      ?>

    </table>
  </div>

</body>

</html>