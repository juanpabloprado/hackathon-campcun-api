<div class="container">
    <h1>Listado de lugares para camping</h1>
    <? if (count($this->places) > 0) :?>
    <table class="table table-striped">
        <tr>
            <th>Nombre</th>
            <th>Direcci&oacute;n</th>
            <th>Tel&eacute;fono</th>
            <th>Email</th>
            <th>Url</th>
            <th>Img</th>
            <th>Coordenadas</th>
            <th>Acciones</th>
        </tr>
        <? foreach($this->places as $place):?>
        <tr>
            <td><?=$place["name"]?></td>
            <td><?=$place["address"]?></td>
            <td><?=$place["phone"]?></td>
            <td><?=$place["email"]?></td>
            <td><?=$place["url"]?></td>
            <td><img src="<?=$place["img_url"]?>" width="100px" height="100px" /></td>
            <td><?=$place["latitude"]?>, <?=$place["longitude"]?></td>
            <td>
                <a href="<?=URL?>index.php/places/viewEdit/<?=$place["id"]?>"><i class="glyphicon glyphicon-eye-open"></i></a>
                <a href="<?=URL?>index.php/places/removeOne/<?=$place["id"]?>"><i class="glyphicon glyphicon-remove"></i></a>
            </td>
        </tr>
        <? endforeach;?>
    </table>
    <? else:?>
    <div class="well well-lg">
        A&uacute;n no hay lugares.
    </div>
    <? endif;?>
</div>