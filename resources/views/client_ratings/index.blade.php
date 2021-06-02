@extends('general.index', $setup);
@section('tbody')
    @foreach ($setup['items'] as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->period }}</td>
            <td>R${{ $item->val}}</td>                 
<td>
    <a href="{{ route( "client_ratings.edit",$item) }}" class="btn btn-primary btn-sm">Editar</a>
    <a href="{{ route( "client_ratings.delete",$item) }}" class="btn btn-danger btn-sm">Deletar</a>
</td>
        </tr>
    @endforeach
@endsection
