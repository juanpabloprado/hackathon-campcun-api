<div class="container">
    <h1>Listado de TODOS para camping</h1>
    <? if (count($this->users) > 0) :?>
    <table class="table table-striped">
        <tr>
            <th>To-Do</th>
            <th>Acciones</th>
        </tr>
        <? foreach($this->todos as $todo):?>
        <tr>
            <td><?=$todo["todo"]?></td>
            <td>
                <a href="<?=URL?>index.php/todos/viewEdit/<?=$todo["id"]?>"><i class="glyphicon glyphicon-eye-open"></i></a>
                <a href="<?=URL?>index.php/todos/removeOne/<?=$todo["id"]?>"><i class="glyphicon glyphicon-remove"></i></a>
            </td>
        </tr>
        <? endforeach;?>
    </table>
    <? else:?>
    <div class="well well-lg">
        A&uacute;n no hay todos.
    </div>
    <? endif;?>
</div>