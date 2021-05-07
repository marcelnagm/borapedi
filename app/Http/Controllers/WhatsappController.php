<?php

namespace App\Http\Controllers;

use App\Imports\RestoImport;
use App\Notifications\RestaurantCreated;
use App\Notifications\WelcomeNotification;
use App\User;
use App\Status;
use App\Models\WhatsappMessage;
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

class WhatsappController extends Controller {

    use Fields;
    use Modules;

    private $parameters = [''];

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
            return view('whatsapp.index', [
                'items' => WhatsappMessage::where('restorant_id', auth()->user()->restorant->id)->orderBy('parameter', 'ASC')->get()
            ]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

    public function new() {
        $all = Status::all();
        $data = array();
        foreach (Status::all() as $item) {
            $data[$item->alias] = $item->name;
        }
        if (auth()->user()->hasRole('owner')) {
            return view('whatsapp.new', [
                'data' => $data
            ]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

    public function edit($id) {
        $all = Status::all();
        $data = array();
        foreach (Status::all() as $item) {
            $data[$item->alias] = $item->name;
        }
        if (auth()->user()->hasRole('owner')) {
            return view('whatsapp.edit', [
                'data' => $data,
                'object' => WhatsappMessage::findOrFail($id)
            ]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

    public function update(Request $request) {
        if (auth()->user()->hasRole('owner')) {
            $requestData = $request->all();

            $message = WhatsappMessage::findOrFail($requestData['id']);
            $message->message = $requestData['mensagem'];
            $message->parameter = $requestData['tipo'];
            $message->save();

            return redirect()->route('whatsapp.index')->withStatus(__('Mengem editada com sucesso'));
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

    public function store(Request $request) {
//          dd($request);
        if (auth()->user()->hasRole('owner')) {
            $requestData = $request->all();

            $message = new WhatsappMessage();
            $message->message = $requestData['mensagem'];
            $message->parameter = $requestData['tipo'];
            $message->restorant_id = auth()->user()->restorant->id;
            $message->save();

            return redirect()->route('whatsapp.index')->withStatus(__('Mengem adicionada com sucesso'));
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

    public function delete($id) {
//        dd($request);
        if (auth()->user()->hasRole('owner')) {

            WhatsappMessage::find($id)->delete();
            return redirect()->route('whatsapp.index')->withStatus(__('Mengem removida com sucesso'));
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

}
