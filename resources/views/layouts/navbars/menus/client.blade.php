<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('orders.index') }}">
            <i class="ni ni-basket text-orange"></i> {{ __('My Orders') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('addresses.index') }}">
            <i class="ni ni-map-big text-green"></i> {{ __('My Addresses') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('coupons.index_client') }}">
            <i class="ni ni-tag text-info"></i> Meus Cupons
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('fidelity_program.index') }}">
             <i style="color:gold;"  class="ni ni-trophy"></i> Meus Programas de Fidelidade
        </a>
    </li>
</ul>
