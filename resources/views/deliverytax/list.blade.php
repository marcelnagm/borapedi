<thead class="thead-light">
    <tr>
        <th class="table-web" scope="col">{{ __('Distance') }}</th>
        <th class="table-web" scope="col">{{ __('Tax') }}</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>Entregas até a distância de : {{$max}}Km</td>
    </tr>
@foreach($taxes as $tax)
<tr>    
    <td class="table-web">
        {{ $tax->distance }} Km
    </td>
    <td class="table-web">
        R$ <?php echo number_format($tax->cost,2); ?>
    </td>
    <td class="table-web">
        <input type="button" class="btn btn-danger" value="x" id="remove_{{$tax->id}}" onclick="remove(this);">
    </td>
</tr>
@endforeach
</tbody>

<script type="text/javascript">
  
  function remove(element){
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
            }, error: function (response) {
                //alert(response.responseJSON.errMsg);
            }
        });
  }
    </script>