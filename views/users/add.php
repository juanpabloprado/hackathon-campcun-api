<div class="container">
    <h1>Agregar Usuario</h1>
    <form id="addUserForm" action="<?=URL?>index.php?url=users/addNew" method="POST">
        <div class="form-group col-sm-12">
            <input class="form-control" type="text" name="name" placeholder="Nombre" />
        </div>
        <div class="form-group col-sm-12">
            <input class="form-control" type="email" name="email" placeholder="Email" />
        </div>
        <div class="form-group col-sm-12">
            <input id="pass1" class="form-control" type="password" name="password" placeholder="Password" />
        </div>
        <div class="form-group col-sm-12">
            <input id="pass2" class="form-control" type="password" name="password2" placeholder="Repite Password" />
        </div>
        
        <div class="form-group col-sm-12">
            <select class="form-control" name="state">
                <option selected>Selecciona un estado</option>
                <option value="QR">Quintana Roo</option>
                <option value="YN">Yucat&aacute;n</option>
            </select>
        </div>
        <div class="form-group col-sm-12">
            <input class="form-control" type="text" name="city" placeholder="Ciudad" />
        </div>
        <div class="form-group col-sm-12">
            <input class="form-control" type="text" name="company" placeholder="Compa&ntilde;ia" />
        </div>
        <div class="form-group col-sm-12">
            <label class="form-inline">
            <input class="form-control" type="checkbox" name="confirmed" />
             Confirmado
            </label>
        </div>
        <div class="form-group col-sm-12">
            <div id="alert" style="display: none" class="alert alert-danger" role="alert">Passwords no valido</div>
        </div>
        <button id="addUser" class="btn btn-primary">Guardar</button>
    </form>
    
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $("#addUser").click(function(e){
            e.preventDefault();
            var pass1 = $("#pass1").val();
            var pass2 = $("#pass2").val();
            if(pass1 == pass2 && pass1 !== ""){
                $("#addUserForm").submit();
            } else {
                $("#alert").show();
            }
        });
    });
</script>