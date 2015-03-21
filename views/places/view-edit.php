<style type="text/css">
  #map-canvas { 
        height: 400px;
        width: 100%;
        display: block;
        background: grey;
    }
</style>
<div class="container">
    <h1>Editar Lugar #<?=$this->place["id"]?></h1>
    <form id="editPlaceForm" action="<?=URL?>index.php?url=places/viewEdit/<?=$this->place["id"]?>" method="POST" enctype="UTF-8">
        
        <div class="form-group col-sm-12">
            *
            <select name="user_id" id="userId" class="form-control">
                <? foreach($this->users as $user):?>
                <option <?=($user["id"]==$this->place["user_id"])?"selected":""?> value="<?=$user["id"]?>"><?=$user["name"]?></option>
                <? endforeach;?>
            </select>
        </div>
        <div class="form-group col-sm-12">
            *
            <input class="form-control" type="text" name="name" placeholder="Nombre" value="<?=$this->place["name"]?>" />
        </div>
        <div class="form-group col-sm-12">
            <textarea name="address" cols="30" rows="3">
                <?=$this->place["address"]?>
            </textarea>
        </div>
        <div class="form-group col-sm-12">
            <input class="form-control" type="text" name="phone" placeholder="Teléfono" value="<?=$this->place["phone"]?>" />
        </div>
        <div class="form-group col-sm-12">
            <input class="form-control" type="text" name="url" placeholder="Url del lugar" value="<?=$this->place["url"]?>" />
        </div>
        <div class="form-group col-sm-12">
            <input class="form-control" type="text" name="img_url" placeholder="Url de una foto" value="<?=$this->place["img_url"]?>" />
        </div>
        <? if($this->place["img_url"] <> ""):?>
        <div class="form-group col-sm-12">
            <img width="200px" height="200px" src="<?=$this->place["img_url"]?>" />
        </div>
        <? endif;?>
        <div class="form-group col-sm-12">
            <div class="input-group">
                <input type="number" class="form-control" name="price_per_person" id="exampleInputAmount" placeholder="Precio por persona" value="<?=$this->place["price_per_person"]?>">
                <div class="input-group-addon">USD</div>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label class="form-inline">
            <input class="form-control" type="checkbox" name="pets" <?=($this->place["pets"]) ? "checked='true'": ""?> />
             Acepta mascotas
            </label>
        </div>
        <hr />
        <div class="form-group col-sm-12">
            <div class="col-sm-12">
                *<label class="text-left">Selecciona un lugar en el mapa</label>
                <input id="latitud" type="text" name="latitude" placeholder="Latitud" value="<?=$this->place["latitude"]?>" />
                <input id="longitud" type="text" name="longitude" placeholder="Longitud" value="<?=$this->place["longitude"]?>" />
            </div>
        </div>
        <div class="form-group col-sm-12">
            <div id="map-canvas" class="centered" style="height: 600px;width: 800px;"></div>
        </div>
        <div class="form-group col-sm-12">
            <div id="alert" style="display: none" class="alert alert-danger" role="alert">Campos faltantes</div>
        </div>
        <button id="editPlace" class="btn btn-primary">Guardar</button>
    </form>
    
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $("#editPlace").click(function(e){
            e.preventDefault();
            var userId = $("#userId").val();
            var latitud = $("#latitud").val();
            var longitud = $("#longitud").val();
            var name = $("#name").val();
            if(userId !== "" && latitud !== "" && longitud !== "" && name !== ""){
                $("#editPlaceForm").submit();
            } else {
                $("#alert").show();
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        function initialize() {
            var image = '<?=$this->imgRoute?>marker.png';
            <?if($this->place["latitude"] <> ""):?>
            alreadyMarked = true;
            var mapOptions = {
              center: { lat: <?=$this->place["latitude"]?>, lng: <?=$this->place["longitude"]?>},
              zoom: 8
            };
            var myLatlng = new google.maps.LatLng(<?=$this->place["latitude"]?>,<?=$this->place["longitude"]?>);
            var marker = new google.maps.Marker({
                position: myLatlng,
                title:"<?=$this->place["name"]?>",
                icon: image,
                draggable: true
            });
            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            marker.setMap(map);
            google.maps.event.addListener(marker, 'dragend', function(evt){
                $('#latitud').val(evt.latLng.lat());
                $('#longitud').val(evt.latLng.lng());
                map.setCenter(marker.position);
                marker.setMap(map);
            });
            
            
            <? else:?>   
            
            
            
            alreadyMarked = false;
            var mapOptions = {
              center: { lat: 21.002357, lng: -87.170852},
              zoom: 8
            };
            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);
            });
            <? endif;?>   
            // To add the marker to the map, call setMap();
            
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
                $('#latitud').val(evt.latLng.lat().toFixed(3));
                $('#longitud').val(evt.latLng.lng().toFixed(3));
                map.setCenter(marker.position);
                marker.setMap(map);
            });
         }
        initialize();
    });
</script>