<?php

namespace App;

use App\Order;
use App\User;
use App\Extras;
use App\Models\Variants;
use App\Address;
use App\Models\OrderHasItems;
use App\Models\WhatsappMessage;

class WhastappService {

    public static function getMobileInfo($name) {
    
//        https://api.borapedi.com:3333/getHostDevice
        
          $ch = curl_init('https://api.borapedi.com:3333/getHostDevice');
# Setup request to send json via POST.
        $payload = json_encode(array(
            "SessionName" => $name,
//            "SessionName" => 'lalala',
                )
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
//# Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//# Send request.
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        curl_close($ch);
        $device = array(
            'session'=> $result['wid']['user'],
            'hw'=> $result['phone']['device_manufacturer'].' - '.$result['platform'],
             'batt'   => $result['plugged']? $result['battery'].'-'. 'Carregando': $result['battery'].'-'.'Descarregando',
             'respond'   => $result['isResponse'] ? 'Está Respondendo' : 'Não Responde',
            );
        
//# Print response.
//        dd($result);   
       return $device;
        
        
    }
    
    public static function isConnected($name, $status = false) {
          $ch = curl_init('https://api.borapedi.com:3333/Start');
# Setup request to send json via POST.
        $payload = json_encode(array(
            "SessionName" => $name,
//            "SessionName" => 'lalala',
                )
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
//# Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//# Send request.
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        curl_close($ch);
        
        $ch = curl_init('https://api.borapedi.com:3333/Status');
# Setup request to send json via POST.
        $payload = json_encode(array(
            "SessionName" => $name,
//            "SessionName" => 'lalala',
                )
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
//# Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//# Send request.
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        curl_close($ch);
//# Print response.
//
// Tratar erro quando node não estiver online
//        dd($result);   
         if ($result== false) {
             return false;
         }
        
        if ($status == false) {
            if ($result['result'] == 'success') {
                return true;
            } else {
                return false;
            }
        } else {
            return $result;
        }
    }

    public static function sendMessage($order, $status) {
        $name = $order->restorant->phone;
          
        if (WhastappService::isConnected($name)) {
//          dd('enviada');
            $message = WhatsappMessage::
                    where('restorant_id', $order->restorant->id)->
                    where('parameter', $status)->
                    first();

            if (isset($message)) {
//                dd('enviada');
                $message = $message->message ;
                if ($status == 1) {
                    
//                    $message = $message->message ;
                    $message .= "\n ".WhastappService::generateTextOrder($order);
                }

                $client_phone = User::find($order->client_id)->phone;
                $client_phone = str_replace('-', '', str_replace(')', '', str_replace('(', '', $client_phone)));
                $client_phone = preg_replace('/\s+/', '','55' . $client_phone);
                $ch = curl_init('https://api.borapedi.com:3333/send');
# Setup request to send json via POST.
//                dd($client_phone);
//                dd($result) ;
                $payload = json_encode(array(
                    'SessionName' => $name,
                    'phone' => $client_phone, // NUMERO A SER ENVIADO EM FORMATO WHATSAPP
                    'type' => 'text', // TIPO (TEXT, FILE, AUDIO, VIDEO, IMAGE)
                    'message' => $message // MENSAGEM PARA SER ENVIADA   
                        )
                );
//dd($message);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_FAILONERROR, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($payload))
                );
//# Return response instead of printing.
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//# Send request.

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    $error_msg = curl_error($ch);
                }
                
                curl_close($ch);
//# Print response.
                return true;
            }
            return false;
    
        } else {
            return false;
        }
    }

    public static function generateTextOrder($order) {
        $title = '\nNovo Pedido'.$order->id.' #' .  "\n\n";

        $price = '*Preço: R$' . $order->order_price . "\n\n";
        $price .= '*Taxa de Entrega: R$' . $order->delivery_price . ' ' . config('settings.cashier_currency') . "\n\n";

        $items = '*Detalhes:' . "\n";

        $list = OrderHasItems::where('order_id', $order->id)->get();
//            dd($list[0]->item()->id,$list[1]->item()->id);
        foreach ($list as $item_k) {
//            dd($item_k);
            $item = $item_k->item();
            $restID = $item->category->restorant->id;
            $cartItemPrice = $item->price;
            $cartItemName = $item->name;
            $theElement = '';
            //                vartiant
            if ($item_k->variant_name != '') {
                $res = explode(',', $item_k->variant_name);
                $variant = Variants::
                        where('item_id', '=', $item->id);
                foreach ($res as $val) {
                    $variant = $variant->where('options', 'like', "%" . $val . "%");
                }
                $variant = $variant->first();
                if ($variant->item->id == $item->id) {
                    $cartItemPrice = $variant->price;

                    //For each option, find the option on the
                    $cartItemName = $item->name . ' ' . $variant->optionsList;
                    //$theElement.=$value." -- ".$item->extras()->findOrFail($value)->name."  --> ". $cartItemPrice." ->- ";
                    $variant = $variant->id;
                } else
                    $variant = '';
            } else
                $variant = '';
//                fim variant                
//                Exctras    
//            dd($item_k->extras);
            if ($item_k->extras != '[]') {
                $res = explode(',', str_replace(']', '', str_replace('[', '', str_replace('"', '', $item_k->extras))));
//                    dd($res);
                foreach ($res as $key => $value) {
                    $extras = explode('+', $value);
                    $extra = Extras::where('item_id', '=', $item->id)->
                                    where('name', '=', $extras[0])->first();
//                         dd($extra);

                    $cartItemName .= "\n " . $extra->name;
                    $cartItemPrice += $extra->price;
                    $theElement .= $extra->name . ' -- ' . $extra->name . '  --> ' . $cartItemPrice . ' ->- ';
                }
                
            }
            $items .= strval($item_k->qty) . ' x ' . $cartItemName . " - R$" . $cartItemPrice ." por cada item". "\n";
        }
        $items .= "\n";
        $final = $title . $price . $items;
        $address =Address::find($order->address_id)->address;
        if ($address != null) {
            $final .= '*Endereço de Entrega:' . "\n" .$address   . "\n\n";
        }
        
        if ($order->comment  != null) {
            $final .= '*Comentário:' . "\n" . $order->comment . "\n\n";
        }
//        dd($final);
        return $final;
        
    }
    

}
