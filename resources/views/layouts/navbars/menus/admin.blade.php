<ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.index') }}">
                <i class="ni ni-basket text-orange"></i> {{ __('Orders') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/live">
                <i class="ni ni-basket text-success"></i> {{ __('Live Orders') }}<div class="blob red"></div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('drivers.index') }}">
                <i class="ni ni-delivery-fast text-pink"></i> {{ __('Drivers') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('clients.index') }}">
                <i class="ni ni-single-02 text-blue"></i> {{ __('Clients') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.restaurants.index') }}">
                <i class="ni ni-shop text-info"></i> {{ __('Restaurants') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('reviews.index') }}">
                <i class="ni ni-diamond text-info"></i> {{ __('Reviews') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cities.index') }}">
                <i class="ni ni-building text-orange"></i> {{ __('Cities') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pages.index') }}">
                <i class="ni ni-ungroup text-info"></i> {{ __('Pages') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('plans.index') }}">
                <i class="ni ni-credit-card text-orange"></i> {{ __('Pricing plans') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('finances.admin') }}">
                <i class="ni ni-money-coins text-blue"></i> {{ __('Finances') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ '/user/' }}">
                <i class="ni ni-money-coins text-blue"></i> Usuarios
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('banners.index') }}">
                <i class="ni ni-album-2 text-green"></i> {{ __('Banners') }}
            </a>
         </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.landing') }}">
                    <i class="ni ni-html5 text-green"></i> {{ __('Landing Page') }}
                </a>
            </li>
        <li class="nav-item">
            <?php
                $theLocaleToOpen=strtolower(config('settings.app_locale'));
                if( strtolower(session('applocale_change')).""!=""){
                    $theLocaleToOpen=strtolower(session('applocale_change'));
                }
            ?>
              <li class="nav-item">
            <a class="nav-link" target="_blank" href="{{ url('/admin/languages')."/".strtolower(config('settings.app_locale'))."/translations" }}">
                <i class="ni ni-world text-orange"></i> {{ __('Translations') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('settings.index') }}">
                <i class="ni ni-settings text-black"></i> {{ __('Site Settings ') }}
            </a>
        </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('apps.index') }}">
                    <i class="ni ni-spaceship text-red"></i> {{ __('Apps') }}
                </a>
            </li>        
        <li class="nav-item">
            <a class="nav-link" href="{{ route('settings.cloudupdate') }}">
                <i class="ni ni-cloud-download-95 text-blue"></i> {{ __('Updates') }}
            </a>
        </li>
</ul>
