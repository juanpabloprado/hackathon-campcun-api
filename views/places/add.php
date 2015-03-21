<style type="text/css">
  #map-canvas { 
        height: 400px;
        width: 100%;
        display: block;
        background: grey;
    }
</style>
<div class="container">
    <h1>Agregar Lugar</h1>
    <form id="addPlaceForm" action="<?=URL?>index.php?url=places/addNew" method="POST" enctype="UTF-8">
        
        <div class="form-group col-sm-12">
            *
            <select name="user_id" id="userId" class="form-control">
                <option selected>Selecciona un usuario</option>
                <? foreach($this->users as $user):?>
                <option value="<?=$user["id"]?>"><?=$user["name"]?></option>
                <? endforeach;?>
            </select>
        </div>
        <div class="form-group col-sm-12">
            *
            <input id="name" class="form-control" type="text" name="name" placeholder="Nombre" />
        </div>
        <div class="form-group col-sm-12">
            <label>Dirección</label>
            <textarea name="address" cols="30" rows="3" class="form-control"></textarea>
        </div>
        <div class="form-group col-sm-12">
            <input class="form-control" type="text" name="phone" placeholder="Teléfono" />
        </div>
        <div class="form-group col-sm-12">
            <input class="form-control" type="text" name="url" placeholder="Url del lugar" />
        </div>
        <div class="form-group col-sm-12">
            <input class="form-control" type="text" name="img_url" placeholder="Url de una foto" />
        </div>
        <div class="form-group col-sm-12" style="display:none">
            <img width="200px" height="200px" src="" />
        </div>
        <div class="form-group col-sm-12">
            <input type="number" name="price_per_person" class="form-control" placeholder="Precio por persona" /> USD
        </div>
        <div class="form-group col-sm-12">
            <label class="form-inline">
            <input class="form-control" type="checkbox" name="pets" />
             Confirmado
            </label>
        </div>
        <hr />
        <div class="form-group col-sm-12">
            <div class="col-sm-12">
                *<label class="text-left">Selecciona un lugar en el mapa</label>
                <input id="latitud" type="text" name="latitude" placeholder="Latitud" />
                <input id="longitud" type="text" name="longitude" placeholder="Longitud"  />
            </div>
        </div>
        <div class="form-group col-sm-12">
            <div id="map-canvas" class="centered" style="height: 600px;width: 800px;"></div>
        </div>
        <div class="form-group col-sm-12">
            <div id="alert" style="display: none" class="alert alert-danger" role="alert">Campos faltantes</div>
        </div>
        <button id="addPlace" class="btn btn-primary">Guardar</button>
    </form>
</div>



<script type="text/javascript">
    $(document).ready(function(){
        $("#addPlace").click(function(e){
            e.preventDefault();
            var userId = $("#userId").val();
            var latitud = $("#latitud").val();
            var longitud = $("#longitud").val();
            var name = $("#name").val();
            if(userId !== "" && latitud !== "" && longitud !== "" && name !== ""){
                $("#addPlaceForm").submit();
            } else {
                $("#alert").show();
            }
        });
    });
</script>
<script type="text/javascript">
    alreadyMarked = false;
    function initialize() {
        var mapOptions = {
            center: { lat: 21.002357, lng: -87.170852},
            zoom: 8
          };
        
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        // To add the marker to the map, call setMap();
        google.maps.event.addListener(map, 'click', function(event) {
            placeMarker(event.latLng);
        });
        
    }   
    function placeMarker(location) {
        if(!alreadyMarked){
            var image = '<?=$this->imgRoute?>marker.png';
            var marker = new google.maps.Marker({
                 position: location, 
                 map: map,
                 icon: image,
                 draggable: true
            });
            $('#latitud').val(location.k);
            $('#longitud').val(location.D);
            alreadyMarked = true;
            console.log(location,"new loc")
        }
        google.maps.event.addListener(marker, 'dragend', function(evt){
            $('#latitud').val(evt.latLng.lat());
            $('#longitud').val(evt.latLng.lng());
            map.setCenter(marker.position);
            marker.setMap(map);
        });
     }
     initialize();
</script>