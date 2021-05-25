<ul class="navbar-nav">
    @if(config('app.ordering'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/live">
            <i class="ni ni-basket text-success"></i> {{ __('Live Orders') }}<div class="blob red"></div>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('whatsapp.index') }}">
            <i class="fa fa-whatsapp text-success"></i>Whatsapp
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link" href="{{ route('orders.index') }}">
            <i class="ni ni-basket text-orangse"></i> {{ __('Orders') }}
        </a>
    </li>
    @endif

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.restaurants.edit',  auth()->user()->restorant->id) }}">
            <i class="ni ni-shop text-info"></i> {{ __('Restaurant') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('items.index') }}">
            <i class="ni ni-collection text-pink"></i> {{ __('Menu') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('reviews.index') }}">
            <i class="ni ni-diamond text-info"></i> {{ __('Reviews') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('clients.index') }}">
            <i class="ni ni-single-02 text-blue"></i> {{ __('Clients') }}
        </a>
    </li>   
    <?php
//        dd(auth()->user()->plan()->first()->name )
    ?>

    @if(auth()->user()->plan()->count() !=  0)

    @if(auth()->user()->plan()->first()->driver_own)
    <li class="nav-item">
        <a class="nav-link" href="{{ route('drivers.index') }}">
            <i class="ni ni-delivery-fast text-pink"></i> {{ __('Drivers') }}
        </a>
    </li>
    @endif
    @if(auth()->user()->plan()->first()->local_table)
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.restaurant.tables.index') }}">
            <i class="ni ni-ungroup text-red"></i> {{ __('Tables') }}
        </a>
    </li>
    @endif
    @endif
    <li class="nav-item">
        <a class="nav-link" href="{{ route('qr') }}">
            <i class="ni ni-mobile-button text-red"></i> {{ __('QR Builder') }}
        </a>
    </li>
    @if (config('app.isqrsaas')&&!config('settings.is_whatsapp_ordering_mode'))

    @if(config('settings.enable_guest_log'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.restaurant.visits.index') }}">
            <i class="ni ni-calendar-grid-58 text-blue"></i> {{ __('Customers log') }}
        </a>
    </li>
    @endif
    @endif

    @if(config('settings.enable_pricing'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('plans.current') }}">
            <i class="ni ni-credit-card text-orange"></i> {{ __('Plan') }}
        </a>
    </li>
    @endif

    @if(config('app.ordering')&&config('settings.enable_finances_owner'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('finances.owner') }}">
            <i class="ni ni-money-coins text-blue"></i> {{ __('Finances') }}
        </a>
    </li>
    @endif


    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.restaurant.coupons.index') }}">
            <i class="ni ni-tag text-pink"></i> {{ __('Coupons') }}
        </a>
    </li>



    <li class="nav-item">
        <a class="nav-link" href="{{ route('share.menu') }}">
            <i class="ni ni-send text-green"></i> {{ __('Share') }}
        </a>
    </li>

</ul>
