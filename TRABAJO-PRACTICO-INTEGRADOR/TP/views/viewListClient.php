<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="container">
<div class="list">
<label for="">LISTADO DE CLIENTES</label>
<table  class="modifyList">
    <tr>
        <th>dni</th>
        <th>nombre</th>
        <th>apellido</th>
    </tr>
<?php
    foreach($this->clientList->GetAll() as $client)
    {
    ?>
        <tr>
        <td><?php echo $client->getDni();?></td>
            <td><?php echo $client->getName();?></td>
            <td><?php echo $client->getLastName();?></td>
    </tr>
        <?php
    }
?>
</table>
</div>
</div>
