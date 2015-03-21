<div class="container">
    <h1>Editar Usuario #<?=$this->user["id"]?></h1>
    <form id="editUserForm" action="<?=URL?>index.php?url=users/viewEdit" method="POST">
        <div class="form-group col-sm-12">
            <input class="form-control" type="text" name="name" placeholder="Nombre" value="<?=$user["name"]?>" />
        </div>
        <div class="form-group col-sm-12">
            <input class="form-control" type="email" name="email" placeholder="Email" value="<?=$user["name"]?>" />
        </div>
        <div class="form-group col-sm-12">
            <input id="pass1" class="form-control" type="password" name="password" placeholder="Password" />
        </div>
        <div class="form-group col-sm-12">
            <input id="pass2" class="form-control" type="password" name="password2" placeholder="Repite Password" />
        </div>
        
        <div class="form-group col-sm-12">
            <select class="form-control" name="state">
                <option>Selecciona un estado</option>
                <option value="QR" <?=($this->user["state"] == "QR") ? "selected": ""?>>Quintana Roo</option>
                <option value="YN" <?=($this->user["state"] == "YN") ? "selected": ""?>>Yucat&aacute;n</option>
            </select>
        </div>
        <div class="form-group col-sm-12">
            <input class="form-control" type="text" name="city" placeholder="Ciudad" value="<?=$user["city"]?>" />
        </div>
        <div class="form-group col-sm-12">
            <input class="form-control" type="text" name="company" placeholder="Compa&ntilde;ia" value="<?=$user["company"]?>" />
        </div>
        <div class="form-group col-sm-12">
            <label class="form-inline">
            <input class="form-control" type="checkbox" name="confirmed" <?=($this->user["confirmed"]) ? "checked='true'": ""?> />
             Confirmado
            </label>
        </div>
        <div class="form-group col-sm-12">
            <div id="alert" style="display: none" class="alert alert-danger" role="alert">Passwords no valido</div>
        </div>
        <button id="editUser" class="btn btn-primary">Guardar</button>
    </form>
    
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $("#editUser").click(function(e){
            e.preventDefault();
            var pass1 = $("#pass1").val();
            var pass2 = $("#pass2").val();
            if(pass1 !== ""){
                $("#editUserForm").submit();
            } else {
                if(pass1 == pass2 && ){
                    $("#alert").show();
                }
            }
        });
    });
</script>