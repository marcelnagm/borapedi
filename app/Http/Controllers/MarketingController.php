<?php

namespace App\Http\Controllers;

use App\Categories;
use App\City;
use App\Events\CallWaiter;
use App\Extras;
use App\Hours;
use App\Imports\RestoImport;
use App\Items;
use App\Models\LocalMenu;
use App\Models\Options;
use App\Notifications\RestaurantCreated;
use App\Notifications\WelcomeNotification;
use App\Plans;
use App\Restorant;
use App\Tables;
use App\User;
use App\Models\DeliveryTax;
use App\Traits\Fields;
use App\Traits\Modules;
use Artisan;
use Carbon\Carbon;
use DB;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
//use Intervention\Image\Image;
use Image;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Spatie\Geocoder\Geocoder;

class MarketingController extends Controller {

    use Fields;
    use Modules;

    private $providerClientes = ClientRatings::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'client_ratings.';

    /**
     * View path.
     */
    private $view_pathClientes = 'client_ratings.';

    /**
     * Parameter name.
     */
    private $parameter_nameClientes = 'client_ratings';

    /**
     * Title of this crud.
     */
    private $titleClientes = 'Classificação  de Cliente';

    /**
     * Title of this crud in plural.
     */
    private $titlePluralClientes = 'Classificação de Clientes';

    private function getFields()
    {
        return [
            ['class'=>'col-md-4', 'ftype'=>'input', 'name'=>'Name', 'id'=>'name', 'placeholder'=>'Enter code name', 'required'=>true],
            ['class'=>'col-md-4', 'ftype'=>'input', 'type'=>'number', 'name'=>'Code', 'id'=>'size', 'placeholder'=>'Enter table person size, ex 4', 'required'=>true],
            ['ftype'=>'select', 'name'=>'Price', 'id'=>'type', 'placeholder'=>'Select type', 'data'=>['Fixed', 'Percentage'], 'required'=>true],
            ['ftype'=>'select', 'name'=>'Active from', 'id'=>'type', 'placeholder'=>'Select type', 'data'=>['Fixed', 'Percentage'], 'required'=>true],
            ['ftype'=>'select', 'name'=>'Active to', 'id'=>'type', 'placeholder'=>'Select type', 'data'=>['Fixed', 'Percentage'], 'required'=>true],
            ['ftype'=>'select', 'name'=>'Limit number', 'id'=>'type', 'placeholder'=>'Select type', 'data'=>['Fixed', 'Percentage'], 'required'=>true],
            ['ftype'=>'select', 'name'=>'Used from', 'id'=>'type', 'placeholder'=>'Select type', 'data'=>['Fixed', 'Percentage'], 'required'=>true],
        ];
    }
    
    private function getFieldsClientes() {
        return [
            ['class' => 'col-md-4', 'ftype' => 'input', 'name' => 'Nome da Classificação', 'id' => 'name', 'placeholder' => 'Enter code name', 'required' => true],
            ['ftype' => 'select', 'name' => 'Periodo contabilizado', 'id' => 'type', 'placeholder' => 'Select type', 'data' => ['Mensal', 'Anual'], 'required' => true],
            ['class' => 'col-md-4', 'ftype' => 'input', 'name' => 'Compras até', 'id' => 'val', 'placeholder' => 'Enter code name', 'required' => true],
        ];
    }

     protected $imagePath = 'uploads/banners/';

    private function getFieldsBanners()
    {
        return [
            ['class'=>'col-md-4', 'ftype'=>'input', 'name'=>'Name', 'id'=>'name', 'placeholder'=>'Enter table name or internal id, ex Table 8', 'required'=>true],
            ['class'=>'col-md-4', 'ftype'=>'select', 'name'=>'Active from', 'id'=>'restoarea_id', 'placeholder'=>'Selec rest area id', 'data'=>'', 'required'=>true],
            ['class'=>'col-md-4', 'ftype'=>'select', 'name'=>'Active to', 'id'=>'restoarea_id', 'placeholder'=>'Selec rest area id', 'data'=>'', 'required'=>true],
        ];
    }
    private function getFieldsFidelity()
    {
        return [
            ['class'=>'col-md-4', 'ftype'=>'input', 'name'=>'Description', 'id'=>'description', 'placeholder'=>'Descricao do Programa', 'required'=>true],
            ['class'=>'col-md-4', 'ftype'=>'input', 'type'=>'number', 'name'=>'Active', 'id'=>'active', 'placeholder'=>'Enter table person size, ex 4', 'required'=>true],
            ['class'=>'col-md-4', 'ftype'=>'input', 'type'=>'float', 'name'=>'Target', 'id'=>'target', 'placeholder'=>'Enter table person size, ex 4', 'required'=>true],
            ['class'=>'col-md-4', 'ftype'=>'input', 'type'=>'float', 'name'=>'Reward', 'id'=>'reward', 'placeholder'=>'Enter table person size, ex 4', 'required'=>true],
            ['class'=>'col-md-4', 'ftype'=>'input', 'type'=>'number', 'name'=>'Vendor/Page', 'id'=>'size', 'placeholder'=>'Enter table person size, ex 4', 'required'=>true],
        ];
    }
    
    /**
     * Auth checker functin for the crud.
     */
    private function authChecker() {
        $this->ownerOnly();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (auth()->user()->hasRole('owner')) {
            return view('marketing.index',
                    ['setup' => [
                            'title' => __('crud.item_managment', ['item' => 'Coupons']),
                            'action_link' => 'coupons/create',
                            'action_name' => __('crud.add_new_item', ['item' => "Coupom"]),
                            'items' => $this->getRestaurant()->coupons()->paginate(config('settings.paginate')),
                            'item_names' => "Coupons",
                            'webroute_path' => "coupon.",
                            'fields' => $this->getFields(),
                            'parameter_name' => "coupon",
                        ],
                        'setup2' => [
                            'title' => __('crud.item_managment', ['item' => "Classificação de Clientes"]),
                            'action_link' => route('client_ratings.create'),
                            'action_name' => __('crud.add_new_item', ['item' => "Classificação de Cliente"]),
                            'items' => $this->getRestaurant()->client_ratings()->paginate(config('settings.paginate')),
                            'item_names' => 'Classificação de Clientes',
                            'webroute_path' => 'client_ratigns.',
                            'fields' => $this->getFieldsClientes(),
                            'parameter_name' => 'client_ratings',
            ],
                        'setup4' => [
                            'title' => __('crud.item_managment', ['item' => "Ofertas (Banners)"]),
                            'action_link' => route('fidelity_program.create'),
                            'action_name' => __('crud.add_new_item', ['item' => "Banner"]),
                            'items' => $this->getRestaurant()->fidelity_program()->paginate(config('settings.paginate')),
                            'item_names' => 'Programas de Fidelidade',
                            'webroute_path' => 'fidelity_program.',
                            'fields4' => $this->getFieldsFidelity(),
                            'parameter_name' => 'fidelity_program',
            ],
                        'setup3' => [
                            'title' => __('crud.item_managment', ['item' => "Programa de Fidelidade"]),
                            'action_link' => route('banners.create'),
                            'action_name' => __('crud.add_new_item', ['item' => "Banner"]),
                            'items' => $this->getRestaurant()->banners()->paginate(config('settings.paginate')),
                            'item_names' => 'Banners',
                            'webroute_path' => 'banners.',
                            'fields' => $this->getFieldsBanners(),
                            'parameter_name' => 'banners',
            ],
                        
                        
                        ]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

}
