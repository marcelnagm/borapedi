<a href="#" class="btn btn-neutral btn-icon web-menu" data-toggle="dropdown" role="button">
    <span class="btn-inner--icon">
        <i class="fa fa-user mr-2"></i>
      </span>
    <span class="nav-link-inner--text">{{ Auth::user()->name }}</span>
</a>
<a href="#" class="nav-link nav-link-icon mobile-menu" data-toggle="dropdown" role="button">
    <span class="btn-inner--icon">
        <i class="fa fa-user mr-2"></i>
      </span>
    <span class="nav-link-inner--text">{{ Auth::user()->name }}</span>
</a>
<div class="dropdown-menu">
    <a href="/profile" class="dropdown-item">{{ __('Profile') }}</a>
    @if(auth()->user()->hasRole('admin'))
        <a href="/home" class="dropdown-item">{{ __('Dashboard') }}</a>
        <a class="dropdown-item " href="/live">{{ __('Live Orders') }}</a>
      
        @if(config('app.ordering')&&config('settings.enable_finances_admin'))
            <a href="{{ route('finances.admin') }}" class="dropdown-item">{{ __('Finances') }}</a>
        @endif
        <a href="/settings" class="dropdown-item">{{ __('Settings') }}</a>
    @endif
    @if(auth()->user()->hasRole('owner'))
        <a href="/home" class="dropdown-item">{{ __('Dashboard') }}</a>
        <a class="dropdown-item " href="/live">{{ __('Live Orders') }}</a>
        <a class="dropdown-item " href="/live">{{ __('Delivery tax') }}</a>
        <a href="/orders" class="dropdown-item">{{ __('Orders') }}</a>
        <a href="{{ route('admin.restaurants.edit', auth()->user()->restorant->id) }}" class="dropdown-item">{{ __('Restaurant') }}</a>
        <a href="/items" class="dropdown-item">{{ __('Menu') }}</a>
        @if(config('app.ordering')&&config('settings.enable_finances_owner'))
            <a href="{{ route('finances.owner') }}" class="dropdown-item">{{ __('Finances') }}</a>
        @endif
        @if(config('settings.enable_pricing'))
            <a href="{{ route('plans.current') }}" class="dropdown-item">{{ __('Plan') }}</a>
        @endif
    @endif
    @if(auth()->user()->hasRole('client'))
        <a href="/orders" class="dropdown-item">{{ __('My Orders') }}</a>
        <a href="/addresses" class="dropdown-item">{{ __('My Addresses') }}</a>        
        <a href="{{ route('client_ratings.index_client') }}" class="dropdown-item">Meus Rankings</a>
        <a href="{{ route('coupons.index_client') }}" class="dropdown-item">Meus Cupons</a>
        <a href="{{ route('fidelity_program.index') }}" class="dropdown-item">Meus Programas de Fidelidade</a>
    @endif
    @if(auth()->user()->hasRole('driver'))
        <a href="/home" class="dropdown-item">{{ __('Dashboard') }}</a>
        <a href="/orders" class="dropdown-item">{{ __('Orders') }}</a>
    @endif

   <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span>{{ __('Logout') }}</span>
    </a>
</div>
