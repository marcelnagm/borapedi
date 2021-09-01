<thead class="thead-light">
    <tr>
        <th scope="col">{{ __('ID') }}</th>
        @hasrole('admin|driver')
            <th scope="col">{{ __('Restaurant') }}</th>
        @endif
        <th class="table-web" scope="col" style='width: 8vw;'>{{ __('Created') }}</th>
        @hasrole('admin|owner|driver')
        <th class="table-web" scope="col">{{ __('Time Slot') }}</th>
        @endif
        <th class="table-web" scope="col">{{ __('Method') }}</th>
        <th scope="col">{{ __('Last status') }}</th>
        @hasrole('admin|owner|driver')
            <th class="table-web" scope="col">{{ __('Client') }}</th>
        @endif
        @hasrole('admin|owner|driver')
            <th class="table-web" scope="col">{{ __('Address') }}</th>
        @endif
        @if(auth()->user()->hasRole('owner'))
            <th class="table-web" scope="col">{{ __('Items') }}</th>
        @endif
        @hasrole('admin|owner')
            <th class="table-web" scope="col">{{ __('Driver') }}</th>
        @endif
        <th class="table-web" scope="col">{{ __('Price') }} + {{ __('Delivery') }}</th>
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner') || auth()->user()->hasRole('driver') || auth()->user()->hasRole('client'))
            <th scope="col">{{ __('Actions') }}</th>
        @endif
    </tr>
</thead>
<tbody>
@foreach($orders as $order)
<tr>
    <td>
        
        <a class="btn badge badge-success badge-pill" href="{{ route('orders.show',$order->id )}}">#{{ $order->id }}</a>
    </td>
    @hasrole('admin|driver')
    <th scope="row">
        <div class="media align-items-center">
            <a class="avatar-custom mr-3">
                <img class="rounded" alt="..." src={{ $order->restorant->icon }}>
            </a>
            <div class="media-body">
                <span class="mb-0 text-sm">{{ $order->restorant->name }}</span>
            </div>
        </div>
    </th>
    @endif

    <td class="table-web" >
        {{ $order->created_at->format(config('settings.datetime_display_format')) }}
    </td>
    
    @hasrole('admin|owner|driver')
    <td class="table-web">
        {{ $order->time_formated }}
    </td>    
    @endif
    <td class="table-web">
        <span class="badge badge-primary badge-pill">{{ $order->getExpeditionType() }}</span>
    </td>
    <td>
        @include('orders.partials.laststatus')
    </td>
    @hasrole('admin|owner|driver')
    <td class="table-web">
       {{ $order->client != null? $order->client->name : 'Nao informado' }}
    </td>
    @endif
    @hasrole('admin|owner|driver')
        <td class="table-web">
            {{ $order->address?$order->address->address:"" }}
        </td>
    @endif
    @if(auth()->user()->hasRole('owner'))
        <td class="table-web">
            {{ count($order->items) }}
        </td>
    @endif
    @hasrole('admin|owner')
        <td class="table-web">
            {{ !empty($order->driver->name) ? $order->driver->name : "" }}
        </td>
    @endif
    <td class="table-web">
        @money( $order->getOrderPrice(), config('settings.cashier_currency'),config('settings.do_convertion'))
            -
        @money( $order->delivery_price, config('settings.cashier_currency'),config('settings.do_convertion'))
    </td>
    @include('orders.partials.actions.table',['order' => $order ])
</tr>
@endforeach
</tbody>
