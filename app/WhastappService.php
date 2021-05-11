<?php

namespace App;

class WhastappService {

    public static function isConnected($order) {
        $ch = curl_init('https://api.borapedi.com:3333/Status');
# Setup request to send json via POST.
        $payload = json_encode(array(
            "SessionName" => '95981110695',
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
//        dd($result);   
        if ($result['result'] == 'success') {
            return true;
        } else {
            return false;
        }
    }

    public static function sendMessage($order, $status) {
        if (WhastappService::isConnected($order)) {
//        dd('entrou');
//        $ch = curl_init('https://www.google.com.br');
//        $ch = curl_init('https://api.borapedi.com:3333/Status');
            $ch = curl_init('https://api.borapedi.com:3333/send');
# Setup request to send json via POST.
            $payload = json_encode(array(
                'SessionName' => '95981110695',
                'phone' => '5595981074892', // NUMERO A SER ENVIADO EM FORMATO WHATSAPP
                'type' => 'text', // TIPO (TEXT, FILE, AUDIO, VIDEO, IMAGE)
                'message' => 'Esta é mensagem eh um teste?' // MENSAGEM PARA SER ENVIADA   
                    )
            );
            
//            dd($payload);
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
            
//            dd($ch);
            $result = curl_exec($ch);
            dd($ch);
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
            }

            dd($error_msg);
            curl_close($ch);
//# Print response.
            dd($result);
            return true;
        } else {
            return false;
        }
    }

}
