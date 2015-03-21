<style type="text/css">
  #map-canvas { height: 100% }
</style>
<div class="container">
    <h1>Agregar Lugar</h1>
    <form id="addPlaceForm" action="<?=URL?>index.php?url=places/addNew" method="POST" enctype="UTF-8">
        
        <div class="form-group col-sm-12">
            *
            <select name="user_id" id="userId">
                <? foreach($this->users as $user):?>
                <option value="<?=$user["id"]?>"><?=$user["name"]?></option>
                <? endforeach;?>
            </select>
        </div>
        <div class="form-group col-sm-12">
            <input class="form-control" type="text" name="name" placeholder="Nombre" />
        </div>
        <div class="form-group col-sm-12">
            <textarea name="address" cols="30" rows="3"></textarea>
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
            <label class="form-inline">
            <input class="form-control" type="checkbox" name="pets" />
             Confirmado
            </label>
        </div>
        <hr />
        <div id="map-canvas"></div>
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
            if(userId !== ""){
                $("#addPlaceForm").submit();
            } else {
                $("#alert").show();
            }
        });
    });
</script>
<script type="text/javascript">
    
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
        google.maps.event.addDomListener(window, 'load', initialize);
    }

        
    function placeMarker(location) {
        var image = '<?=$this->imagesRoute?>marker.png';
         var marker = new google.maps.Marker({
             position: location, 
             map: map,
             icon: image
         });
     }
</script>