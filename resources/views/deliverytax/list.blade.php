<thead class="thead-light">
    <tr>
        <th class="table-web" scope="col">{{ __('Distance') }}</th>
        <th class="table-web" scope="col">{{ __('Tax') }}</th>
    </tr>
</thead>
<tbody>
@foreach($taxes as $tax)
<tr>    
    <td class="table-web">
        {{ $tax->distance }} Km
    </td>
    <td class="table-web">
        R$ <?php echo number_format($tax->cost,2); ?>
    </td>
</tr>
@endforeach
</tbody>
