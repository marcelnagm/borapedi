<?php

namespace App\Http\Controllers;

use App\Models\FidelityProgram;
use App\Pages;
use App\Restorant;
use Illuminate\Http\Request;

class FidelityProgramController extends Controller
{
    /**
     * Provide class.
     */
    private $provider = FidelityProgram::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'fidelity.';

    /**
     * View path.
     */
    private $view_path = 'fidelity_program.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'fidelity_program';

    /**
     * Title of this crud.
     */
    private $title = 'fidelity';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'fidelity_programs';


    private function getFields()
    {
        return [
            ['class'=>'col-md-4', 'ftype'=>'input', 'name'=>'Name', 'id'=>'name', 'placeholder'=>'Enter table name or internal id, ex Table 8', 'required'=>true],
            ['class'=>'col-md-4', 'ftype'=>'input', 'type'=>'number', 'name'=>'Vendor/Page', 'id'=>'size', 'placeholder'=>'Enter table person size, ex 4', 'required'=>true],
            ['class'=>'col-md-4', 'ftype'=>'select', 'name'=>'Active from', 'id'=>'restoarea_id', 'placeholder'=>'Selec rest area id', 'data'=>'', 'required'=>true],
            ['class'=>'col-md-4', 'ftype'=>'select', 'name'=>'Active to', 'id'=>'restoarea_id', 'placeholder'=>'Selec rest area id', 'data'=>'', 'required'=>true],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $this->adminOnly();
        
        
        
  return view($this->view_path.'index', ['setup' => [
            'title'=>__('crud.item_managment', ['item'=>__($this->titlePlural)]),
            'items'=> auth()->user()->fidelity_program()->paginate(config('settings.paginate')),
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
//        $this->adminOnly();

        $restaurants = Restorant::where(['active'=>1])->get();
        $restaurantsData = [];
        foreach ($restaurants as $key => $restaurant) {
            $restaurantsData[$restaurant->id] = $restaurant->name;
        }

        $pages = Pages::all();
        $pagesData = [];
        foreach ($pages as $key => $page) {
            $pagesData[$page->id] = $page->title;
        }

        return view('fidelity_program.create', ['restaurants' => $restaurantsData, 'pages' => $pagesData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->adminOnly();

        
        $item = $this->provider::create([
            'restaurant_id' => $request->restaurant_id,
            'active' =>$request->active ==true? 1 : 0,
            'type_target' => $request->type_target,
            'target_value' => $request->target_value,
            'target_orders' => $request->target_orders,
            'type_reward' => $request->type_reward,
            'reward' => $request->reward,
            'type_coupon' => $request->type_coupon,            
        ]);


        $item->save();

        return redirect()->route('marketing.index')->withStatus(__('crud.item_has_been_added', ['item'=>__($this->title)]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
                $item = $this->provider::findOrFail($id);

          return view('fidelity_program.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function edit(FidelityProgram $banner)
    {
//        $this->adminOnly();


        return view('fidelity_program.create', ['banner' => $banner]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $this->adminOnly();
        
//        dd($request->active =="true"? 1 : 0);

        $item = $this->provider::findOrFail($id);
         
        $item->active = $request->active =="true"? 1 : 0;
        $item->type_target= $request->type_target;
        $item->target_orders= $request->target_orders;
        $item->target_value= $request->target_value;
        $item->type_reward= $request->type_reward;
        $item->reward= $request->reward;
        $item->type_coupon= $request->type_coupon;
                
        
            $item->update();

        return redirect()->route('marketing.index')->withStatus(__('crud.item_has_been_updated', ['item'=>__($this->title)]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $this->adminOnly();

        $item = $this->provider::findOrFail($id);
        $item->delete();

        //TODO -- Delete customers from this table
        return redirect()->route('marketing.index')->withStatus(__('crud.item_has_been_removed', ['item'=>__($this->title)]));
    }
}
