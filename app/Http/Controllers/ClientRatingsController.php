<?php

namespace App\Http\Controllers;

use App\Models\ClientRatings;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientRatingsController extends Controller
{
    /**
     * Provide class.
     */
    private $provider = ClientRatings::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'client_ratings.';

    /**
     * View path.
     */
    private $view_path = 'client_ratings.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'client_ratings';

    /**
     * Title of this crud.
     */
    private $title = 'Fidelizacao de Cliente';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'Fidelizacao de Clientes';

    private function getFields()
    {
        return [
            ['class'=>'col-md-4', 'ftype'=>'input', 'name'=>'Nome da Classificação', 'id'=>'name', 'placeholder'=>'Enter code name', 'required'=>true],
            ['ftype'=>'select', 'name'=>'Periodo contabilizado', 'id'=>'type', 'placeholder'=>'Select type', 'data'=>['Mensal', 'Anual'], 'required'=>true],
            ['class'=>'col-md-4', 'ftype'=>'input', 'name'=>'Compras até', 'id'=>'val', 'placeholder'=>'Enter code name', 'required'=>true],
        ];
    }

    /**
     * Auth checker functin for the crud.
     */
    private function authChecker()
    {
        $this->ownerOnly();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_client()
    {
     return view($this->view_path.'index_client', [
            'ratings' => auth()->user()->client_has_rating()
        ]);
    }
    
    public function index()
    {
        $this->authChecker();

        return view($this->view_path.'index', ['setup' => [
            'title'=>__('crud.item_managment', ['item'=>__($this->titlePlural)]),
            'action_link'=>route($this->webroute_path.'create'),
            'action_name'=>__('crud.add_new_item', ['item'=>__($this->title)]),
            'items'=>$this->getRestaurant()->client_ratings()->paginate(config('settings.paginate')),
            'item_names'=>$this->titlePlural,
            'webroute_path'=>$this->webroute_path,
            'fields'=>$this->getFields(),
            'parameter_name'=>$this->parameter_name,
        ]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authChecker();

        return view('client_ratings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request);
        $this->authChecker();
        $item = $this->provider::create([
            'name' => $request->name,
            'period' => $request->Meses,
            'val' => $request->Val,
            'restaurant_id' => $this->getRestaurant()->id,
        ]);

        $item->save();

        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_added', ['item'=>__($this->title)]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupons  $coupons
     * @return \Illuminate\Http\Response
     */
    public function show(Coupons $coupons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupons  $coupons
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientRatings $coupon)
    {
        return view('client_ratings.create', ['coupon' => $coupon]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupons  $coupons
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authChecker();
        $item = $this->provider::findOrFail($id);
        $item->name = $request->name;
        $item->period = $request->Meses;
        $item->val = $request->Val;
        $item->update();

        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_updated', ['item'=>__($this->title)]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupons  $coupons
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authChecker();
        $item = $this->provider::findOrFail($id);
        $item->delete();

        //TODO -- Delete customers from this table
        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_removed', ['item'=>__($this->title)]));
    }

    
}
