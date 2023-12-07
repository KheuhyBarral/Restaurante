<div>
  <?php

    require_once("classes/r.class.php");

    R::setup('mysql:host=localhost;dbname=restaurante', 'root', '');

    $produtos = R::findAll("produtos");

    $r = "<table><tr>
                <th>Id</th>
                <th>Descrição</th>
                <th>Valor</th>
            </tr>";
    foreach ($produtos as $p) {
      $r = $r .
        "<tr>
        <td>" . $p->id . "</td>" .
        "<td>" . $p->descricao . "</td>" .
        "<td>R$ " . $p->valor . "</td>";
      
    }

    $r = $r . "</table>";

    echo $r;

    R::close();
  ?>
</div>