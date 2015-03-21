<style type="text/css">
  #map-canvas { height: 100% }
</style>
<div class="container">
    <h1>Editar Lugar #<?=$this->place["id"]?></h1>
    <form id="editPlaceForm" action="<?=URL?>index.php?url=places/viewEdit/<?=$this->place["id"]?>" method="POST" enctype="UTF-8">
        
        <div class="form-group col-sm-12">
            *
            <select name="user_id" id="userId">
                <? foreach($this->users as $user):?>
                <option <?=($user["id"]==$this->place["user_id"])?"selected":""?> value="<?=$user["id"]?>"><?=$user["name"]?></option>
                <? endforeach;?>
            </select>
        </div>
        <div class="form-group col-sm-12">
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
            <label class="form-inline">
            <input class="form-control" type="checkbox" name="pets" <?=($this->place["pets"]) ? "checked='true'": ""?> />
             Acepta mascotas
            </label>
        </div>
        <hr />
        <div id="map-canvas"></div>
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
            if(userId !== ""){
                $("#editPlaceForm").submit();
            } else {
                $("#alert").show();
            }
        });
    });
</script>
<script type="text/javascript">
    function initialize() {
      var mapOptions = {
        center: { lat: <?=$this->place["latitud"]?>, lng: <?=$this->place["longitude"]?>},
        zoom: 8
      };
      var map = new google.maps.Map(document.getElementById('map-canvas'),
          mapOptions);
    }
    
    // add marker
    var myLatlng = new google.maps.LatLng(<?=$this->place["latitud"]?>,<?=$this->place["longitude"]?>);
    var mapOptions = {
      zoom: 8,
      center: myLatlng
    }
    var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
    var image = '<?=$this->imagesRoute?>marker.png';
    var marker = new google.maps.Marker({
        position: myLatlng,
        title:"<?=$this->place["name"]?>",
        icon: image
    });

    // To add the marker to the map, call setMap();
    marker.setMap(map);
    // click
    google.maps.event.addListener(map, 'click', function(event) {
        placeMarker(event.latLng);
    });
    google.maps.event.addDomListener(window, 'load', initialize);
    function placeMarker(location) {
         var marker = new google.maps.Marker({
             position: location, 
             map: map
         });
     }
</script>