<div class="container">
    <h1>Editar Todo #<?=$this->todo["id"]?></h1>
    <form id="editTodoForm" action="<?=URL?>index.php?url=todos/viewEdit/<?=$this->todo["id"]?>" method="POST">
        <div class="form-group col-sm-12">
            <input id="todo" class="form-control" type="text" name="todo" placeholder="Todo" value="<?=$this->todo["todo"]?>" />
        </div>
        <div class="form-group col-sm-12">
            <div id="alert" style="display: none" class="alert alert-danger" role="alert">To-Do Necesario</div>
        </div>
        <button id="editTodo" class="btn btn-primary">Guardar</button>
    </form>
    
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $("#editTodo").click(function(e){
            e.preventDefault();
            var todo = $("#todo").val();
            if(todo !== ""){
                $("#editTodoForm").submit();
            } else {
                $("#alert").show();
            }
        });
    });
</script>