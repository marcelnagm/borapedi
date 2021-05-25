
<thead class="thead-light">
    <tr>
        <th class="" scope="col">Distância</th>
        <th class="" scope="col">Taxa</th>
        <th class="" scope="col">Ações</th>
    </tr>
</thead>
<tbody>
    @if(count($taxes)>0)
    <tr>
        <td colspan="3">Entregas até a distância de : {{$max}}Km</td>
    </tr>
    @foreach($taxes as $tax)
    <tr>    
        <td class="" id="edit_d_{{$tax->id}}" onclick="edit(this);" style=' cursor: pointer; '>
            {{ $tax->distance }} Km
        </td>
        <td class="" id="edit_c_{{$tax->id}}" onclick="edit(this);" style=' cursor: pointer;'>
            R$ <?php
            echo number_format($tax->cost, 2);
            $val[] = $tax->distance;
            ?>
        </td>
        <td class="">
            <input type="button" class="btn btn-danger" value="x" id="remove_{{$tax->id}}" onclick="remove(this);" alt="Remover">
        </td>
    </tr>
    @endforeach
    @else
    <tr>
        <td colspan='3'>Nenhuma Taxa Adicionada</td>
    </tr>
    @endif
</tbody>

<script type="text/javascript">

    function remove(element) {
        //console.log(formatAMPM("19:05"));

        var id = element.id.split("_").pop();
        console.log(id);
//        event.preventDefault();
//
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/deliverytax/delete',
//            dataType: 'json',
            data: {
                id: id
            },
            success: function (response) {
//                alert('sucess');
                console.log(response.text);
                $("#result").html(response);
                $("#map_canvas").html();
                drawmap();
            }, error: function (response) {
                //alert(response.responseJSON.errMsg);
            }
        });
    }


    function getColor() {
        var red = (Math.floor((256 - 50) * Math.random()));
        var green = (Math.floor((256 - 50) * Math.random()));
        var blue = (Math.floor((256 - 50) * Math.random()));
        var color = "#" + red.toString(16) + green.toString(16) + blue.toString(16);
        return color;
    }
var show = false;

    function edit(element) {
        if(show== false){
        var id_n = element.id;
        var valu = document.getElementById(id_n).innerText
        $(element).html('<input id="' + id_n + '" value="' + valu + '" onblur="send(this);">');
        show = true;
        }
    }

    function send(element) {
        show = false;
        
        var id = element.id;
        var values = element.value.replace('Km','').replace('R$','');
        console.log(id);
//        event.preventDefault();
//
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/deliverytax/edit',
//            dataType: 'json',
            data: {
                id: id,
                val: values
            },
            success: function (response) {
//                alert('sucess');
                console.log(response.text);
                $("#result").html(response);
                $("#map_canvas").html();
                drawmap();
            }, error: function (response) {
                //alert(response.responseJSON.errMsg);
            }
        });
    }

    function drawmap() {
//        var colors = ['black', 'cyan', 'black yellow', 'black green'];
<?php
if (isset($val)) {
    $js_array = json_encode($val);
    echo "var values_k = " . $js_array . ";\n";
}
?>
        var map = new google.maps.Map(document.getElementById("map_canvas"),
                {
                    zoom: 11,
                    center: new google.maps.LatLng(lat, lng
                            ),
                    mapTypeId: google.maps.MapTypeId.roadmap
                });
        const myLatLng = {lat: lat, lng: lng};
        new google.maps.Marker({
            position: myLatLng,
            map,
            title: "Nosso Restaurante",
        });
        for (var $i = 0; $i < values_k.length; $i++) {
            var circulo = new google.maps.Circle(
                    {
                        map: map,
                        center: new google.maps.LatLng(lat, lng),
                        radius: values_k[$i] * 1000, // 1000 metros = 1k.
                        strokeColor: getColor(),
                        fillColor: "white",
                        fillOpacity: 0.15,
                    });
        }

    }
</script>