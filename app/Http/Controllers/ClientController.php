<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole('owner')) {
            $client = User::select('users.*')
            ->join('orders', 'orders.client_id', '=', 'users.id')
            ->join('model_has_roles', 'orders.client_id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.model_type', '=', 'App\User')
            ->where('model_has_roles.role_id', '=', 4)
            ->where('users.active', '=', 1)
            ->where('orders.restorant_id', '=', auth()->user()->restorant->id)
            ->groupby('users.id')->distinct()        
            ->paginate(10);
            ////Get driver's orders
            return view('clients.index_client', [
                    'clients' => $client
                ]
            );
        } 
         if (auth()->user()->hasRole('admin')) {
            $client = User::role('client')->where(['active'=>1])->paginate(15);
            ////Get driver's orders
            return view('clients.index', [
                    'clients' => $client
                ]
            );
        } 
    if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')) {
            
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
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
    public function edit(User $client)
    {
        if (auth()->user()->hasRole('admin')) {
            return view('clients.edit', compact('client'));
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
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
    public function destroy(User $client)
    {
        $client->active = 0;
        $client->save();

        return redirect()->route('clients.index')->withStatus(__('Client successfully deleted.'));
    }
}
