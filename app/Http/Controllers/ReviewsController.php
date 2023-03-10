<?php

namespace App\Http\Controllers;

use App\Ratings;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if (auth()->user()->hasRole('owner')) {
            $ratings = Ratings::select()
            ->join('orders', 'ratings.order_id', '=', 'orders.id')
            ->where('restorant_id', '=', auth()->user()->restorant->id)
            ->paginate(10);
            ////Get driver's orders
        } 
         if (auth()->user()->hasRole('admin')) {
            $ratings = Ratings::paginate(10);
            ////Get driver's orders
        } 
        return view('reviews.index', ['setup' => [
            'title'=>__('Order reviews'),
            'action_link'=>'',
            'action_name'=>'',
            'items'=> $ratings,
            'item_names'=>__('reviews'),
        ]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ratings $rating)
    {
        $rating->delete();

        return redirect()->route('reviews.index')->withStatus(__('Rating has been removed'));
    }
}
