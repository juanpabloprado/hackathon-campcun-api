<div class="container">
    <h1>Listado de TODOS para camping</h1>
    <a class="btn btn-success" href="<?=URL?>index.php?url=todos/addNew">Agregar To-Do</a>
    <br /><br />
    <? if (count($this->todos) > 0) :?>
    <table class="table table-striped">
        <tr>
            <th>To-Do</th>
            <th>Acciones</th>
        </tr>
        <? foreach($this->todos as $todo):?>
        <tr>
            <td><?=$todo["todo"]?></td>
            <td>
                <a href="<?=URL?>index.php?url=todos/viewEdit/<?=$todo["id"]?>"><i class="glyphicon glyphicon-eye-open"></i></a>
                <a class="delete" data-id="<?=$todo["id"]?>"><i class="glyphicon glyphicon-remove"></i></a>
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

<script type="text/javascript">
    $(document).ready(function(){
        $(".delete").click(function(e){
            e.preventDefault;
            var id = $(this).attr("data-id");
            var r = confirm("Estas seguro de que deseas borrar éste elemento?");
            if (r == true) {
                window.location.href = "<?=URL?>index.php?url=todos/removeOne/"+id;
            } 
        });
    });
</script>