<div class="container">
    <h1>Listado de Usuarios</h1>
    <a class="btn btn-success" href="<?=URL?>index.php?url=users/addNew">Agregar Usuario</a>
    <br /><br />
    <? if (count($this->users) > 0) :?>
    <table class="table table-striped">
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Estado</th>
            <th>Ciudad</th>
            <th>Compa&ntilde;ia</th>
            <th>Confirmado</th>
            <th>Acciones</th>
        </tr>
        <? foreach($this->users as $user):?>
        <tr>
            <td><?=$user["name"]?></td>
            <td><?=$user["email"]?></td>
            <td><?=$user["state"]?></td>
            <td><?=$user["city"]?></td>
            <td><?=$user["company"]?></td>
            <td><?=($user["confirmed"]) ? "si" : "no";?></td>
            <td>
                <a href="<?=URL?>index.php/users/viewEdit/<?=$user["id"]?>"><i class="glyphicon glyphicon-eye-open"></i></a>
                <a href="<?=URL?>index.php/users/removeOne/<?=$user["id"]?>"><i class="glyphicon glyphicon-remove"></i></a>
            </td>
        </tr>
        <? endforeach;?>
    </table>
    <? else:?>
    <div class="well well-lg">
        A&uacute;n no hay usuarios.
    </div>
    <? endif;?>
</div>